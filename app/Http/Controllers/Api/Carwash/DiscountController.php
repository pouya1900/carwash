<?php

namespace App\Http\Controllers\Api\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{


    public function index()
    {
        try {
            $carwash = $this->request->carwash;

            $discounts = $carwash->discounts;

            return $this->sendResponse([
                "discounts" => DiscountResource::collection($discounts),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function store()
    {
        try {
            $carwash = $this->request->carwash;

            $carwash->discounts()->create([
                "value" => $this->request->input("value"),
                "start" => date("Y-m-d H:i", strtotime($this->request->input("times")[0])),
                "end"   => date("Y-m-d H:i", strtotime($this->request->input("times")[1])),
            ]);

            return $this->sendResponse([], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function delete(Discount $discount)
    {
        try {
            $carwash = $this->request->carwash;

            if ($carwash->id != $discount->carwash->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $discount->delete();

            return $this->sendResponse([], trans("messages.crud.deletedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }
}
