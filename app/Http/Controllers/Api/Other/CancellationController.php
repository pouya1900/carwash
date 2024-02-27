<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CancellationController extends Controller
{

    public function rules(Reservation $reservation)
    {
        try {
            $setting = Setting::first();

            if ($reservation->time->start > Carbon::now()->addHours($setting->free_cancellation_time)) {
                $plan = "free";
            } elseif ($reservation->time->start > Carbon::now()->addHours($setting->cancellation_time)) {
                $plan = "charge";
            } else {
                $plan = "no";
            }

            return $this->sendResponse([
                "freeCancellationTime" => $setting->free_cancellation_time,
                "CancellationTime"     => $setting->cancellation_time,
                "CancellationCharge"   => $setting->cancellation_charge,
                "plan"                 => $plan,
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }


}
