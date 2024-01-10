<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Traits\ResponseUtilsTrait;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use ResponseUtilsTrait;

    public function index()
    {
        try {
            $user = $this->request->user;

            $per_page = $this->getPerPage();

            $addresses = $user->addresses()->paginate($per_page);

            return $this->sendResponse([
                "addresses"  => AddressResource::collection($addresses),
                'pagination' => [
                    "totalItems"      => $addresses->total(),
                    "perPage"         => $addresses->perPage(),
                    "nextPageUrl"     => $addresses->nextPageUrl(),
                    "previousPageUrl" => $addresses->previousPageUrl(),
                    "lastPageUrl"     => $addresses->url($addresses->lastPage()),
                ],
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function store(StoreAddressRequest $request)
    {
        try {
            $user = $this->request->user;

            $address = $user->addresses()->create([
                "state_id"    => $request->input("state_id"),
                "city_id"     => $request->input("city_id"),
                "area"        => $request->input("area") ?? "",
                "block"       => $request->input("block") ?? "",
                "street"      => $request->input("street") ?? "",
                "lat"         => $request->input("lat"),
                "long"        => $request->input("long"),
                "description" => $request->input("description") ?? "",
                "pluck"       => $request->input("pluck") ?? "",
                "floor"       => $request->input("floor") ?? "",
            ]);

            return $this->sendResponse([
                "address" => new AddressResource($address),
            ], trans("messages.crud.createdModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


    public function update(StoreAddressRequest $request, Address $address)
    {
        try {
            $user = $this->request->user;

            if ($user->id != $address->user->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $address->update([
                "state_id"    => $request->input("state_id"),
                "city_id"     => $request->input("city_id"),
                "area"        => $request->input("area") ?? "",
                "block"       => $request->input("block") ?? "",
                "street"      => $request->input("street") ?? "",
                "lat"         => $request->input("lat"),
                "long"        => $request->input("long"),
                "description" => $request->input("description") ?? "",
                "pluck"       => $request->input("pluck") ?? "",
                "floor"       => $request->input("floor") ?? "",
            ]);

            return $this->sendResponse([
                "address" => new AddressResource($address),
            ], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


    public function delete(Address $address)
    {
        try {
            $user = $this->request->user;

            if ($user->id != $address->user->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $address->delete();

            return $this->sendResponse([], trans("messages.crud.deletedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


}
