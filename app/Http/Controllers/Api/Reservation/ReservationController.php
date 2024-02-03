<?php

namespace App\Http\Controllers\Api\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Models\Setting;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function reserve()
    {
        try {
            $user = $this->request->user;
            $setting = Setting::first();

            if ($gift = $user->gifts()->where("status", "pending")->first()) {
                $gift->update([
                    "number" => $gift->number + 1,
                    "status" => $gift->number + 1 == $gift->total ? "completed" : "pending",
                ]);
            } else {
                $user->gifts()->create([
                    "number" => 1,
                    "total"  => $setting->gift_number,
                    "value"  => $setting->gift_value,
                    "status" => "pending",
                ]);
            }

            return $this->sendResponse([
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}
