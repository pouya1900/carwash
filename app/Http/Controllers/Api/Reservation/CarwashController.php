<?php

namespace App\Http\Controllers\Api\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarwashFullResource;
use App\Http\Resources\CarwashResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ServiceResource;
use App\Models\Carwash;
use App\Models\Product;
use Illuminate\Http\Request;

class CarwashController extends Controller
{

    public function index()
    {
        try {
            $per_page = $this->getPerPage();

            $carwashes = Carwash::paginate($per_page);

            return $this->sendResponse([
                "carwashes"  => CarwashResource::collection($carwashes),
                'pagination' => [
                    "totalItems"      => $carwashes->total(),
                    "perPage"         => $carwashes->perPage(),
                    "nextPageUrl"     => $carwashes->nextPageUrl(),
                    "previousPageUrl" => $carwashes->previousPageUrl(),
                    "lastPageUrl"     => $carwashes->url($carwashes->lastPage()),
                ],
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }

    public function show(Carwash $carwash)
    {
        try {

            return $this->sendResponse([
                "carwash" => new CarwashFullResource($carwash),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }


    public function products()
    {
        try {
            $per_page = $this->getPerPage();

            $search = $this->request->input("search");
            $carwash_id = $this->request->input("carwash_id");
            $categories_id = json_decode($this->request->input("categories_id"), true);

            $products = Product::when($search, function ($q) use ($search) {
                return $q->where("title", "like", "%$search%")->orwhere("description", "like", "%$search%");
            })->when($carwash_id, function ($q) use ($carwash_id) {
                return $q->where("carwash_id", $carwash_id);
            })->when(!empty($categories_id), function ($q) use ($categories_id) {
                return $q->whereIn("category_id", $categories_id);
            })->paginate($per_page);

            return $this->sendResponse([
                "products"   => ProductResource::collection($products),
                'pagination' => [
                    "totalItems"      => $products->total(),
                    "perPage"         => $products->perPage(),
                    "nextPageUrl"     => $products->nextPageUrl(),
                    "previousPageUrl" => $products->previousPageUrl(),
                    "lastPageUrl"     => $products->url($products->lastPage()),
                ],
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function services(Carwash $carwash)
    {
        try {
            $per_page = $this->getPerPage();

            $services = $carwash->services()->paginate($per_page);

            return $this->sendResponse([
                "products"   => ServiceResource::collection($services),
                'pagination' => [
                    "totalItems"      => $services->total(),
                    "perPage"         => $services->perPage(),
                    "nextPageUrl"     => $services->nextPageUrl(),
                    "previousPageUrl" => $services->previousPageUrl(),
                    "lastPageUrl"     => $services->url($services->lastPage()),
                ],
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}
