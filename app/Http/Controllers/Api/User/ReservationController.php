<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Models\Carwash;
use App\Models\Lock_product;
use App\Models\Lock_service;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Setting;
use App\Traits\ResponseUtilsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use ResponseUtilsTrait;

    public function index()
    {
        try {
            $user = $this->request->user;

            $per_page = $this->getPerPage();

            $reservations = $user->reservations()->paginate($per_page);

            return $this->sendResponse([
                "reservations" => ReservationResource::collection($reservations),
                'pagination'   => [
                    "totalItems"      => $reservations->total(),
                    "perPage"         => $reservations->perPage(),
                    "nextPageUrl"     => $reservations->nextPageUrl(),
                    "previousPageUrl" => $reservations->previousPageUrl(),
                    "lastPageUrl"     => $reservations->url($reservations->lastPage()),
                ],
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function reserve()
    {
        try {
            $user = $this->request->user;
            $setting = Setting::first();

            $carwash_id = $this->request->input("carwash_id");
            $service_id = $this->request->input("service_id");
            $products_id = $this->request->input("products_id");

            $carwash = Carwash::find($carwash_id);
            $service = Service::find($service_id);
            $products = Product::whereIn("id", $products_id)->get();

            if (!$service) {
                return $this->sendError(trans('messages.response.failed'));
            }

            if (!$products->count()) {
                return $this->sendError(trans('messages.response.failed'));
            }

            $reservation = Reservation::create([
                "carwash_id" => $carwash->id,
                "user_id"    => $user->id,
                "status"     => "created",
                "price"      => 0,
            ]);

            $lock_service = Lock_service::create([
                "carwash_id"  => $service->carwash_id,
                "title"       => $service->base->title,
                "description" => $service->base->description,
                "items"       => json_encode($service->items()->get()->pluck("title")->toArray()),
                "time"        => $service->time,
                "price"       => $service->price,
                "discount"    => $service->discount,
            ]);
            $reservation->services()->attach($lock_service);

            foreach ($products as $product) {
                $lock_product = Lock_product::create([
                    "carwash_id"  => $product->carwash_id,
                    "product_id"  => $product->id,
                    "title"       => $product->title,
                    "description" => $product->description,
                    "price"       => $product->price,
                ]);

                $logo = $product->logo["model"];
                $new_logo = $logo->replicate();
                $new_logo->created_at = Carbon::now();
                $new_logo->updated_at = Carbon::now();
                $new_logo->mediable_type = Lock_product::class;
                $new_logo->mediable_id = $lock_product->id;
                $new_logo->save();

                foreach ($product->images as $image) {
                    $new_image = $image["model"]->replicate();
                    $new_image->created_at = Carbon::now();
                    $new_image->updated_at = Carbon::now();
                    $new_image->mediable_type = Lock_product::class;
                    $new_image->mediable_id = $lock_product->id;
                    $new_image->save();
                }

                $reservation->products()->attach($lock_product);
            }


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

    public function cancel(Reservation $reservation)
    {
        try {
            $user = $this->request->user;

            return $this->sendResponse([
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function score(Reservation $reservation)
    {
        try {
            $user = $this->request->user;

            $rate = $this->request->input("rate");
            $comment = $this->request->input("comment");

            $reservation->score()->create([
                "scorable_id"   => $reservation->carwash->id,
                "scorable_type" => Carwash::class,
                "rate"          => $rate,
                "comment"       => $comment,
            ]);

            return $this->sendResponse([
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }
}
