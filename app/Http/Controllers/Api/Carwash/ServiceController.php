<?php

namespace App\Http\Controllers\Api\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Item;
use App\Models\Service;
use App\Models\Type;
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
                "base_id"  => $request->input("base_id"),
                "time"     => $request->input("time"),
                "status"   => $request->input("status"),
                "price"    => $request->input("price"),
                "discount" => $request->input("discount") ?? 0,
                "is_main"  => $request->input("is_main") ?? 0,
            ]);

            foreach ($request->input("items") as $item_id) {
                $item = Item::find($item_id);
                if ($item) {
                    $service->items()->attach($item);
                }
            }

            foreach ($request->input("types") as $type_id) {
                $type = Type::find($type_id);
                if ($type) {
                    $service->types()->attach($type);
                }
            }

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
                "base_id"  => $request->input("base_id"),
                "time"     => $request->input("time"),
                "status"   => $request->input("status"),
                "price"    => $request->input("price"),
                "discount" => $request->input("discount") ?? 0,
                "is_main"  => $request->input("is_main") ?? 0,
            ]);

            $service->items()->detach();
            foreach ($request->input("items") as $item_id) {
                $item = Item::find($item_id);
                if ($item) {
                    $service->items()->attach($item);
                }
            }

            $service->types()->detach();
            foreach ($request->input("types") as $type_id) {
                $type = Type::find($type_id);
                if ($type) {
                    $service->types()->attach($type);
                }
            }

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

            $service->items()->detach();
            $service->types()->detach();
            $service->delete();

            return $this->sendResponse([], trans("messages.crud.deletedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}
