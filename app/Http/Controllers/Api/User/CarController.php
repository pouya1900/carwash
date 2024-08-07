<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAddressRequest;
use App\Http\Requests\Api\StoreCarRequest;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CarResource;
use App\Models\Address;
use App\Models\Car;
use App\Models\Media;
use App\Traits\ResponseUtilsTrait;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    use ResponseUtilsTrait, UploadUtilsTrait;

    public function index()
    {
        try {
            $user = $this->request->user;

            $per_page = $this->getPerPage();

            $cars = $user->cars()->paginate($per_page);

            return $this->sendResponse([
                "cars"       => CarResource::collection($cars),
                'pagination' => [
                    "totalItems"      => $cars->total(),
                    "perPage"         => $cars->perPage(),
                    "nextPageUrl"     => $cars->nextPageUrl(),
                    "previousPageUrl" => $cars->previousPageUrl(),
                    "lastPageUrl"     => $cars->url($cars->lastPage()),
                ],
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function store(StoreCarRequest $request)
    {
        try {
            $user = $this->request->user;

            $plate = $request->input("plate");

            if ($user->cars()->where('plate1', $plate["plate1"])->where('plate2', $plate["plate2"])->where('region', $plate["region"])->where('index', $plate["index"])->where('symbol', $plate["symbol"])->where('custom', $plate["custom"])->where('plate_type', $plate["type"])->first()) {
                return $this->sendError(trans('messages.crud.exist'));
            }

            $car = $user->cars()->create([
                "type_id"    => $request->input("type_id"),
                "model_id"   => $request->input("model_id"),
                "color_id"   => $request->input("color_id"),
                "year"       => $request->input("year"),
                "region"     => $plate["region"] ?? "",
                "index"      => $plate["index"] ?? "",
                "plate1"     => $plate["plate1"] ?? "",
                "plate2"     => $plate["plate2"] ?? "",
                "symbol"     => $plate["symbol"] ?? "",
                "custom"     => $plate["custom"] ?? "",
                "plate_type" => $plate["type"] ?? "",
            ]);

            $images_id = [$request->input("image_id")];
            $this->updateImages($car, 'carImage', "assetsStorage", $images_id);

            return $this->sendResponse([
                "car" => new CarResource($car),
            ], trans("messages.crud.createdModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


    public function update(StoreCarRequest $request, Car $car)
    {
        try {
            $user = $this->request->user;

            if ($user->id != $car->user->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            if ($request->input("is_default") && !$car->is_default) {
                $user->cars()->update([
                    "is_default" => 0,
                ]);
            }

            $plate = $request->input("plate");

            $car->update([
                "type_id"    => $request->input("type_id"),
                "model_id"   => $request->input("model_id"),
                "color_id"   => $request->input("color_id"),
                "year"       => $request->input("year"),
                "is_default" => $request->input("is_default"),
                "region"     => $plate["region"] ?? "",
                "index"      => $plate["index"] ?? "",
                "plate1"     => $plate["plate1"] ?? "",
                "plate2"     => $plate["plate2"] ?? "",
                "symbol"     => $plate["symbol"] ?? "",
                "custom"     => $plate["custom"] ?? "",
                "plate_type" => $plate["type"] ?? "",
            ]);


            $images_id = [$request->input("image_id")];
            $this->updateImages($car, 'carImage', "assetsStorage", $images_id);

            return $this->sendResponse([
                "car" => new CarResource($car),
            ], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function delete(Car $car)
    {
        try {
            $user = $this->request->user;

            if ($user->id != $car->user->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $car->media()->delete();
            $car->delete();

            return $this->sendResponse([], trans("messages.crud.deletedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function clearDefault()
    {
        try {
            $user = $this->request->user;

            $user->cars()->update([
                "is_default" => 0,
            ]);

            return $this->sendResponse([], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function makeDefault(Car $car)
    {
        try {
            $user = $this->request->user;

            if ($user->id != $car->user->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $user->cars()->update([
                "is_default" => 0,
            ]);

            $car->update([
                "is_default" => 1,
            ]);

            return $this->sendResponse([], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}
