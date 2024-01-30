<?php

namespace App\Http\Controllers\Api\Reservation;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarwashFullResource;
use App\Http\Resources\CarwashResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ServiceResource;
use App\Models\Carwash;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class CarwashController extends Controller
{

    public function index()
    {
        try {
            $per_page = $this->getPerPage();


            $lat = $this->request->input("lat");
            $long = $this->request->input("long");
            $radius = $this->request->input("radius") ?: 10;

            $carwashes = Carwash::when($lat, function ($q) use ($lat, $long, $radius) {
                $rad = M_PI / 180;
                $r = 6371; //earth radius in kilometers
                return $q->whereRaw("(acos( sin( lat * $rad ) * sin( $lat * $rad ) + cos( lat * $rad ) * cos( $lat * $rad ) * cos( carwashes.long * $rad - $long * $rad ) ) * $r ) < $radius  ")
                    ->orderByRaw("acos( sin( lat * $rad ) * sin( $lat * $rad ) + cos( lat * $rad ) * cos( $lat * $rad ) * cos( carwashes.long * $rad - $long * $rad ) ) * $r  ASC");
            })->paginate($per_page);


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

            $lat = $this->request->input("lat");
            $long = $this->request->input("long");
            $radius = $this->request->input("radius") ?: 10;


            $products = Product::when($search, function ($q) use ($search) {
                return $q->where("title", "like", "%$search%")->orwhere("description", "like", "%$search%");
            })->when($carwash_id, function ($q) use ($carwash_id) {
                return $q->where("carwash_id", $carwash_id);
            })->when(!empty($categories_id), function ($q) use ($categories_id) {
                return $q->whereIn("category_id", $categories_id);
            })->when($lat, function ($q) use ($lat, $long, $radius) {
                $rad = M_PI / 180;
                $r = 6371; //earth radius in kilometers
                return $q->wherehas("carwash", function ($q) use ($lat, $long, $radius) {
                    $rad = M_PI / 180;
                    $r = 6371; //earth radius in kilometers
                    return $q->whereRaw("(acos( sin( lat * $rad ) * sin( $lat * $rad ) + cos( lat * $rad ) * cos( $lat * $rad ) * cos( carwashes.long * $rad - $long * $rad ) ) * $r ) < $radius  ");
                })->join("carwashes", "carwashes.id", "products.carwash_id")->orderByRaw("acos( sin( carwashes.lat * $rad ) * sin( $lat * $rad ) + cos( carwashes.lat * $rad ) * cos( $lat * $rad ) * cos( carwashes.long * $rad - $long * $rad ) ) * $r ASC");
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
                "services"   => ServiceResource::collection($services),
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

    public function product_show(Product $product)
    {
        try {

            return $this->sendResponse([
                "product" => new ProductResource($product),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }

    public function service_show(Service $service)
    {
        try {
            return $this->sendResponse([
                "service" => new ServiceResource($service),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }

    public function times(Carwash $carwash)
    {
        try {
            $free_times = Helper::getFreeTimes($carwash);

            return $this->sendResponse([
                "free" => $free_times,
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function categories()
    {
        try {
            $per_page = $this->getPerPage();

            $categories = Category::paginate($per_page);

            return $this->sendResponse([
                "categories" => CategoryResource::collection($categories),
                'pagination' => [
                    "totalItems"      => $categories->total(),
                    "perPage"         => $categories->perPage(),
                    "nextPageUrl"     => $categories->nextPageUrl(),
                    "previousPageUrl" => $categories->previousPageUrl(),
                    "lastPageUrl"     => $categories->url($categories->lastPage()),
                ],
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}
