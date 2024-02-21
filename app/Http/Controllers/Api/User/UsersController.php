<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\UserResource;
use App\Models\Gift;
use App\Services\Payment\Payment;
use App\Services\Payment\Zarinpal;
use App\Traits\ResponseUtilsTrait;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use ResponseUtilsTrait, UploadUtilsTrait;

    public function show()
    {
        try {
            $user = $this->request->user;
            return $this->sendResponse([
                "user" => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            dd($e);
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

            $payment = new Payment(new Zarinpal());

            $response = $payment->createPayment();
            return $this->sendResponse([
                "link" => "https://paymentpageexample",
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function verifyPayment()
    {
        dd($this->request->all());
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
                "balance" => $user->balance + $gift->value,
            ]);

            return $this->sendResponse([], trans("messages.gift.success", ["value" => $gift->value]));
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}
