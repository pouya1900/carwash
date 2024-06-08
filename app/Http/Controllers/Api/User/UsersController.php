<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateUserLocationRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\UserResource;
use App\Models\Gift;
use App\Models\Payment;
use App\Services\Payment\PaymentGateway;
use App\Services\Payment\Zarinpal;
use App\Traits\ResponseUtilsTrait;
use App\Traits\UploadUtilsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use ResponseUtilsTrait, UploadUtilsTrait;

    public function show()
    {
        try {
            $user = $this->request->user;

//            $reservation = $user->reservations()->wherein("status", ["approved", "doing"])->wherehas("time", function ($q) {
//                return $q->wherebetween("start", [Carbon::now()->subHours(2), Carbon::now()->addMinutes(30)]);
//            })->first();

            $reservation = $user->reservations()->selectRaw("reservations.*")->wherein("status", ["approved", "doing"])->wherehas("time", function ($q) {
                return $q->where("start", ">", Carbon::now()->subHours(2));
            })->join('time_tables', 'time_tables.reservation_id', 'reservations.id')->orderBy('time_tables.start', 'asc')->first();
            return $this->sendResponse([
                "user"        => new UserResource($user),
                "reservation" => $reservation ? new ReservationResource($reservation) : null,
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function update(UpdateUserRequest $request)
    {
        try {
            $user = $this->request->user;

            $user->update([
                'first_name' => $request->input("first_name"),
                'last_name'  => $request->input("last_name"),
                'email'      => $request->input("email"),
            ]);

            $images_id = [$request->input("image_id")];
            $this->updateImages($user, 'avatar', "assetsStorage", $images_id);

            return $this->sendResponse([
                "user" => new UserResource($user),
            ], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function increaseBalance()
    {
        try {
            $user = $this->request->user;

            $amount = $this->request->input("amount");

            if (!$amount || !is_numeric($amount)) {
                return $this->sendError(trans('messages.payment.amountInvalid'));
            }

            $payment = $user->payments()->create([
                "wallet"       => 0,
                "online"       => $amount,
                "cash"         => 0,
                "total"        => $amount,
                "coupon_value" => 0,
                "coupon_code"  => "",
                "status"       => "pending",
            ]);

            $payment_instance = new PaymentGateway(new Zarinpal());

            $callback_url = route("verifyPayment", $payment->id);

            $response = $payment_instance->createPayment($amount, $callback_url);

            if ($response["status"]) {
                return $this->sendError(trans('messages.payment.makePaymentFail'));
            }

            return $this->sendResponse([
                "link" => $response["link"],
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.payment.makePaymentFail'));
        }
    }

    public function inactive()
    {
        try {
            $user = $this->request->user;
            $user->update([
                "inactive",
            ]);
            auth("user")->logout();
            return $this->sendResponse([], trans("messages.auth.logOutSuccess"));
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function receive_gift(Gift $gift)
    {
        try {
            $user = $this->request->user;

            if ($user->id != $gift->user->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            if ($gift->status == "pending") {
                return $this->sendError(trans('messages.gift.notCompleted'));
            }

            if ($gift->status == "received") {
                return $this->sendError(trans('messages.gift.alreadyReceived'));
            }

            if ($gift->status != "completed") {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $gift->update([
                "status" => "received",
            ]);

            $user->update([
                "balance"      => $user->balance + $gift->value,
                "gift_balance" => $user->gift_balance + $gift->value,
            ]);

            return $this->sendResponse([], trans("messages.gift.success", ["value" => $gift->value]));
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function firebaseUpdate()
    {
        try {
            $user = $this->request->user;

            $user->update([
                'firebase_token' => $this->request->input("firebase_token"),
            ]);

            return $this->sendResponse([
                "user" => new UserResource($user),
            ], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function update_location(UpdateUserLocationRequest $request)
    {
        try {
            $user = $this->request->user;

            $user->update([
                'lat'  => $request->input("lat"),
                'long' => $request->input("long"),
            ]);

            return $this->sendResponse([
                "user" => new UserResource($user),
            ], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


}
