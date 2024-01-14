<?php

namespace App\Http\Controllers\Api\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Traits\ResponseUtilsTrait;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    use ResponseUtilsTrait;

    public function index()
    {
        try {
            $carwash = $this->request->carwash;

            $per_page = $this->getPerPage();

            $services = $carwash->services()->paginate($per_page);

            return $this->sendResponse([
                "services"   => ServiceResource::collection($services),
                'pagination' => [
                    "totalItems"      => $services->total(),
                    "perPage"         => $services->perPage(),
                    "nextPageUrl"     => $services->nextPageUrl(),
                    "previousPageUrl" => $services->previousPageUrl(),
                    "lastPageUrl"     => $services->url($services->lastPage()),
                ],
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function store(StoreServiceRequest $request)
    {
        try {
            $carwash = $this->request->carwash;

            $service = $carwash->services()->create([
                "title"       => $request->input("title"),
                "description" => $request->input("description") ?? "",
                "items"       => $request->input("items") ? json_encode($request->input("items")) : "[]",
                "time"        => $request->input("time"),
                "status"      => $request->input("status"),
                "price"       => $request->input("price"),
                "discount"    => $request->input("discount") ?? 0,
            ]);

            return $this->sendResponse([
                "service" => new ServiceResource($service),
            ], trans("messages.crud.createdModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


    public function update(StoreServiceRequest $request, Service $service)
    {
        try {
            $carwash = $this->request->carwash;

            if ($carwash->id != $service->carwash->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $service->update([
                "title"       => $request->input("title"),
                "description" => $request->input("description") ?? "",
                "items"       => $request->input("items") ? json_encode($request->input("items")) : "[]",
                "time"        => $request->input("time"),
                "status"      => $request->input("status"),
                "price"       => $request->input("price"),
                "discount"    => $request->input("discount") ?? 0,
            ]);

            return $this->sendResponse([
                "service" => new ServiceResource($service),
            ], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


    public function delete(Service $service)
    {
        try {
            $carwash = $this->request->carwash;

            if ($carwash->id != $service->carwash->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $service->delete();

            return $this->sendResponse([], trans("messages.crud.deletedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}
