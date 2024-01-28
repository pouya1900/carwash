<?php

namespace App\Http\Controllers\Api\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Resources\OffTimeResource;
use App\Http\Resources\UsedTimeResource;
use App\Models\Time_table;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function schedule()
    {
        try {
            $days = $this->request->input("days");
            $carwash = $this->request->carwash;

            if (!$schedule = $carwash->schedule) {
                $schedule = $carwash->schedule()->create();
            }

            $schedule->update([
                "day0" => $days[0] ? json_encode($days[0]) : "",
                "day1" => $days[1] ? json_encode($days[1]) : "",
                "day2" => $days[2] ? json_encode($days[2]) : "",
                "day3" => $days[3] ? json_encode($days[3]) : "",
                "day4" => $days[4] ? json_encode($days[4]) : "",
                "day5" => $days[5] ? json_encode($days[5]) : "",
                "day6" => $days[6] ? json_encode($days[6]) : "",
            ]);

            return $this->sendResponse([], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function index()
    {
        try {
            $carwash = $this->request->carwash;

            $used_times = $carwash->times()->whereNotNull("reservation_id")->orderBy("start", "asc")->get();
            $off_times = $carwash->times()->whereNull("reservation_id")->orderBy("start", "asc")->get();

            return $this->sendResponse([
                "usedTimes" => UsedTimeResource::collection($used_times),
                "offTimes"  => OffTimeResource::collection($off_times),
            ], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function update()
    {
        try {
            $carwash = $this->request->carwash;

            $carwash->times()->create([
                "label" => $this->request->input("label"),
                "start" => date("Y-m-d H:i", strtotime($this->request->input("times")[0])),
                "end"   => date("Y-m-d H:i", strtotime($this->request->input("times")[1])),
            ]);

            return $this->sendResponse([], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function delete(Time_table $time)
    {
        try {
            $carwash = $this->request->carwash;

            if ($time->carwash->id != $carwash->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $time->delete();

            return $this->sendResponse([], trans("messages.crud.deletedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }
}
