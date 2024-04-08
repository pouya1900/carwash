<?php

namespace App\Http\Controllers\Servant;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Time_table;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function index()
    {
        $servant = $this->request->current_servant;

        $schedule = $servant->schedule;

        return view('servant.times.index', compact('servant', 'schedule'));
    }

    public function update()
    {
        try {
            $servant = $this->request->current_servant;

            $d = $this->request->input('d');
            $days = [];
            foreach ($d as $key => $item) {
                if ($item) {
                    $array = [];
                    foreach ($item as $key2 => $time) {
                        if ((is_null($time['start']) || $time['start'] < 0 || $time['start'] > 24) || (is_null($time['end']) || $time['end'] <= $time['start'])) {
                            $h = Helper::week_day($key);
                            return redirect()->back()->withErrors(['error' => "بازه زمانی روز $h اشتباه است."]);
                        }
                        $array[$key2][0] = $time['start'];
                        $array[$key2][1] = $time['end'];
                    }
                    $days[$key] = json_encode($array);
                }
            }
            if (!$schedule = $servant->schedule) {
                $schedule = $servant->schedule()->create();
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
            return redirect(route('servant_times'))->with('message', trans('trs.changed_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function timetable()
    {
        $day = Carbon::now();

        $day_week = $day->weekday();
        $servant = $this->request->current_servant;

        $schedule = $servant->schedule;

        $time_table = $servant->times()->orderBy('start', 'asc')->get();

        $days = [];

        $today = Carbon::now()->endOfDay();
        $counter = 0;
        foreach ($time_table as $item) {
            if ($item->start < Carbon::now()->startOfDay()) {
                continue;
            }

            if ($item->reservation?->status == "canceled" || $item->reservation?->status == "rejected") {
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
                "user"        => $item->reservation?->user->fullName,
                "reservation" => $item->reservation ?? null,
                "start"       => date("H", strtotime($item->start)),
                "start_part"  => $this->getMinuteNumber($item->start),
                "end"         => date("H", strtotime($item->end)),
                "end_part"    => $this->getMinuteNumber($item->end),
                "label"       => $item->label,
                "remove_url"  => route('servant_time_remove', $item->id),
            ];
        }
        return view('servant.times.timetable', compact('servant', 'days', 'schedule'));
    }

    public function timetableUpdate()
    {
        try {
            $servant = $this->request->current_servant;
            $start = $this->request->input('start');
            $start_part = $this->request->input('start_part');
            $end = $this->request->input('end');
            $end_part = $this->request->input('end_part');
            $date = date('Y-m-d', strtotime($this->request->input('date')));
            $label = $this->request->input('label');

            $time = $servant->times()->create([
                'start' => date('Y-m-d H:i', strtotime($date . ' ' . $start . ':' . $start_part * 15)),
                'end'   => date('Y-m-d H:i', strtotime($date . ' ' . $end . ':' . $end_part * 15)),
                'label' => $label,
            ]);
            return response()->json(['status' => 0, 'remove_url' => route('servant_time_remove', $time->id)]);
        } catch (\Exception $e) {
            return response()->json(['status' => 1]);
        }

    }

    public function remove(Time_table $time)
    {
        try {
            $servant = $this->request->current_servant;

            if ($time->servant->id != $servant->id) {
                abort(403);
            }

            $time->delete();
            return response()->json(['status' => 0]);
        } catch (\Exception $e) {
            return response()->json(['status' => 1]);
        }
    }

    public function getMinuteNumber($date)
    {
        $time = date("i", strtotime($date));
        switch ($time) {
            case 0 :
                return 0;
            case 15 :
                return 1;
            case 30 :
                return 2;
            case 45 :
                return 3;
        }
        return 0;
    }

}
