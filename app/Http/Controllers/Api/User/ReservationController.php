<?php

namespace App\Http\Controllers\Api\User;

use App\Helper;
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
use Morilog\Jalali\Jalalian;

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
            $car_id = $this->request->input("vehicle_id");
            $type_id = $this->request->input("type_id");
            $service_id = $this->request->input("service_id");
            $products_model = $this->request->input("products");
            $use_balance = $this->request->input("use_balance");
            $j_date = $this->request->input("date");
            $time = $this->request->input("time");

            $carwash = Carwash::find($carwash_id);
            $service = Service::find($service_id);
            if (!$service) {
                return $this->sendError(trans('messages.response.failed'));
            }
            $reservation = Reservation::create([
                "carwash_id" => $carwash->id,
                "user_id"    => $user->id,
                "status"     => "created",
                "price"      => 0,
                "car_id"     => $car_id,
                "type_id"    => $type_id,
            ]);


            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();
            $discount_object = Helper::hasDiscount($carwash, $date, $time);
            $discount = $discount_object ? $discount_object->value : 0;

            $lock_service = Lock_service::create([
                "carwash_id"  => $service->carwash_id,
                "title"       => $service->base->title,
                "description" => $service->base->description,
                "items"       => json_encode($service->items()->get()->pluck("title")->toArray()),
                "time"        => $service->time,
                "price"       => $service->price,
                "discount"    => max($service->discount, $discount),
            ]);
            $reservation->services()->attach($lock_service);
            $service_price = $lock_service->price * (1 - $lock_service->discount / 100);


            $products_price = 0;
            foreach ($products_model as $product_model) {

                $product = Product::find($product_model["id"]);

                if (!$product) {
                    continue;
                }

                $lock_product = Lock_product::create([
                    "carwash_id"  => $product->carwash_id,
                    "product_id"  => $product->id,
                    "title"       => $product->title,
                    "description" => $product->description,
                    "price"       => $product->price,
                    "discount"    => $product->discount,
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

                $reservation->products()->attach($lock_product, ["quantity" => $product_model["quantity"]]);

                $product_price = $lock_product->price * (1 - $lock_product->discount / 100);
                $products_price += $product_price * $product_model["quantity"];
            }

            $total_price = $products_price + $service_price;

            $reservation->update([
                "price" => $total_price,
            ]);

            $reservation->time()->create([
                "carwash_id" => $carwash->id,
                "start"      => $date->copy()->startOfDay()->addHours($time),
                "end"        => $date->copy()->startOfDay()->addHours($time + 1),
            ]);

            $online = $total_price;
            $wallet = 0;
            if ($use_balance) {
                if ($user->balance >= $total_price) {
                    $online = 0;
                    $wallet = $total_price;
                } else {
                    $online = $total_price - $user->balance;
                    $wallet = $user->balance;
                }
            }

            $reservation->payment()->create([
                "user_id"      => $user->id,
                "wallet"       => $wallet,
                "online"       => $online,
                "cash"         => 0,
                "total"        => $total_price,
                "coupon_value" => 0,
                "coupon_code"  => "",
                "status"       => "pending",
            ]);

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
                "reservation" => new ReservationResource($reservation),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function cancel(Reservation $reservation)
    {
        try {
            $user = $this->request->user;
            $setting = Setting::first();

            if ($reservation->status != "approved") {
                return $this->sendError(trans('messages.reservation.cantCancel'));
            }

            if ($reservation->time->start > Carbon::now()->addHours($setting->free_cancellation_time)) {
                $reservation->update([
                    "status" => "canceled",
                ]);

                $user->update([
                    "balance" => $user->balance + $reservation->price,
                ]);
                return $this->sendResponse([
                ], trans('messages.reservation.canceledSuccessful'));
            } elseif ($reservation->time->start > Carbon::now()->addHours($setting->cancellation_time)) {

                $reservation->update([
                    "status" => "canceled",
                ]);

                $user->update([
                    "balance" => $user->balance + $reservation->price * (1 - $setting->cancellation_charge / 100),
                ]);
                return $this->sendResponse([
                ], trans('messages.reservation.canceledSuccessful'));
            } else {
                return $this->sendError(trans('messages.reservation.cantCancel'));
            }

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
