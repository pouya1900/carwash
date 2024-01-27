<?php

namespace App\Http\Controllers\Api\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateCarwashRequest;
use App\Http\Resources\CarwashFullResource;
use App\Traits\ResponseUtilsTrait;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class CarwashController extends Controller
{
    use  ResponseUtilsTrait, UploadUtilsTrait;

    public function show()
    {
        try {
            $carwash = $this->request->carwash;

            return $this->sendResponse([
                "carwash" => new CarwashFullResource($carwash),
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function update(UpdateCarwashRequest $request)
    {
        try {
            $carwash = $this->request->carwash;

            $carwash->update([
                "title"    => $request->input("title"),
                "lat"      => $request->input("lat"),
                "long"     => $request->input("long"),
                "address"  => $request->input("address"),
                "city_id"  => $request->input("city_id"),
                "state_id" => $request->input("state_id"),
                "payment"  => $request->input("payment"),
                "type"     => $request->input("type"),
            ]);


            $images_id = [$request->input("logo_id")];
            $this->updateImages($carwash, 'carwashLogo', "assetsStorage", $images_id);

            $images_id = $request->input("images_id");
            $this->updateImages($carwash, 'carwashImages', "assetsStorage", $images_id);


            return $this->sendResponse([
                "carwash" => new CarwashFullResource($carwash),
            ], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

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

}
