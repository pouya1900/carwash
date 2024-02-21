<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CancellationController extends Controller
{

    public function rules()
    {
        try {
            $setting = Setting::first();

            return $this->sendResponse([
                "freeCancellationTime" => $setting->free_cancellation_time,
                "CancellationTime"     => $setting->cancellation_time,
                "CancellationCharge"   => $setting->cancellation_charge,
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }


}
