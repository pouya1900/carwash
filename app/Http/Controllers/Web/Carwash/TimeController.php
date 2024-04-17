<?php

namespace App\Http\Controllers\Web\Carwash;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Time_table;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function index()
    {
        $carwash = $this->request->current_carwash;

        $schedule = $carwash->schedule;
        return view('carwash.times.index', compact('carwash', 'schedule'));
    }

    public function update()
    {
        try {
            $carwash = $this->request->current_carwash;

            $d = $this->request->input('d');
            $days = [];
            foreach ($d as $key => $item) {
                if ($item) {
                    $array = [];
                    $array["times"] = [];
                    $array["number"] = $item["number"];
                    $times = $item["times"];
                    foreach ($times as $key2 => $time) {
                        if ((is_null($time['start']) || $time['start'] < 0 || $time['start'] > 24) || (is_null($time['end']) || $time['end'] <= $time['start'])) {
                            $h = Helper::week_day($key);
                            return redirect()->back()->withErrors(['error' => "بازه زمانی روز $h اشتباه است."]);
                        }
                        $array["times"][$key2][0] = $time['start'];
                        $array["times"][$key2][1] = $time['end'];
                    }
                    $days[$key] = json_encode($array);
                }
            }
            if (!$schedule = $carwash->schedule) {
                $schedule = $carwash->schedule()->create();
            }


            $schedule->update([
                "day0" => $days[1] ?? "[]",
                "day1" => $days[2] ?? "[]",
                "day2" => $days[3] ?? "[]",
                "day3" => $days[4] ?? "[]",
                "day4" => $days[5] ?? "[]",
                "day5" => $days[6] ?? "[]",
                "day6" => $days[0] ?? "[]",
            ]);
            return redirect(route('carwash_times'))->with('message', trans('trs.changed_successfully'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function timetable()
    {
        $day = Carbon::now();

        $day_week = $day->weekday();
        $carwash = $this->request->current_carwash;

        $schedule = $carwash->schedule;

        $time_table = $carwash->times()->orderBy('start', 'asc')->get();

        $days = [];

        $today = Carbon::now()->endOfDay();
        $counter = 0;
        foreach ($time_table as $item) {
            if ($item->start < Carbon::now()->startOfDay()) {
                continue;
            }

            if ($item->reservation?->status == "canceled") {
                continue;
            }

            if (!isset($days[$counter])) {
                $days[$counter] = [];
            }
            while ($today < $item->start) {
                $counter++;
                $days[$counter] = [];
                $today->addDay();
            }
            $days[$counter][] = [
                "car_type"    => $item->reservation?->car?->type?->title,
                "car_model"   => $item->reservation?->car?->model?->brand?->title . " " . $item->reservation?->car?->model?->title,
                "reservation" => $item->reservation ?? null,
                "start"       => date("H", strtotime($item->start)),
                "end"         => date("H", strtotime($item->end)),
                "label"       => $item->label,
                "remove_url"  => route('carwash_time_remove', $item->id),
            ];
        }
        return view('carwash.times.timetable', compact('carwash', 'days', 'schedule'));
    }

    public function timetableUpdate()
    {
        try {
            $carwash = $this->request->current_carwash;
            $start = $this->request->input('start');
            $end = $this->request->input('end');
            $date = date('Y-m-d', strtotime($this->request->input('date')));
            $label = $this->request->input('label');

            $time = $carwash->times()->create([
                'start' => date('Y-m-d H:i', strtotime($date . ' ' . $start . ':00')),
                'end'   => date('Y-m-d H:i', strtotime($date . ' ' . $end . ':00')),
                'label' => $label,
            ]);
            return response()->json(['status' => 0, 'remove_url' => route('carwash_time_remove', $time->id)]);
        } catch (\Exception $e) {
            return response()->json(['status' => 1]);
        }

    }

    public function remove(Time_table $time)
    {
        try {
            $carwash = $this->request->current_carwash;

            if ($time->carwash->id != $carwash->id) {
                abort(403);
            }

            $time->delete();
            return response()->json(['status' => 0]);
        } catch (\Exception $e) {
            return response()->json(['status' => 1]);
        }
    }

}
