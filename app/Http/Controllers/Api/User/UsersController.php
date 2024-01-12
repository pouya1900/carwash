<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\UserResource;
use App\Traits\ResponseUtilsTrait;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use ResponseUtilsTrait;

    public function show()
    {
        $user = $this->request->user;

        return $this->sendResponse([
            "user" => new UserResource($user),
        ]);

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


//            payment
//            payment

            return $this->sendResponse([
                "link" => "https://paymentpageexample",
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}