<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepositResource;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    public function index()
    {
        try {
            $user = $this->request->user;

            $per_page = $this->getPerPage();

            $deposits = $user->deposits()->paginate($per_page);

            return $this->sendResponse([
                "deposits"   => DepositResource::collection($deposits),
                'pagination' => [
                    "totalItems"      => $deposits->total(),
                    "perPage"         => $deposits->perPage(),
                    "nextPageUrl"     => $deposits->nextPageUrl(),
                    "previousPageUrl" => $deposits->previousPageUrl(),
                    "lastPageUrl"     => $deposits->url($deposits->lastPage()),
                ],
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function store()
    {

        try {
            $user = $this->request->user;
            $amount = $this->request->input("amount");
            $bank_id = $this->request->input("bank_id");

            if ($user->balance - $user->gift_balance < intval($amount)) {
                return $this->sendError(trans('messages.payment.insufficientError'));
            }

            $deposit = $user->deposits()->create([
                "bank_id" => $bank_id,
                "total"   => $amount,
                "status"  => "requested",
                "message" => "",
            ]);

            $user->update([
                "balance" => $user->balance - $amount,
            ]);

            return $this->sendResponse([
                "deposit" => new DepositResource($deposit),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }


    }

}
