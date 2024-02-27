<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankResource;
use Illuminate\Http\Request;

class BankController extends Controller
{

    public function index()
    {
        try {
            $user = $this->request->user;

            $per_page = $this->getPerPage();

            $banks = $user->banks()->paginate($per_page);

            return $this->sendResponse([
                "banks"      => BankResource::collection($banks),
                'pagination' => [
                    "totalItems"      => $banks->total(),
                    "perPage"         => $banks->perPage(),
                    "nextPageUrl"     => $banks->nextPageUrl(),
                    "previousPageUrl" => $banks->previousPageUrl(),
                    "lastPageUrl"     => $banks->url($banks->lastPage()),
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

            $name = $this->request->input("name");
            $card = $this->request->input("card");
            $shaba = $this->request->input("shaba");

            $bank = $user->banks()->create([
                "name"  => $name,
                "card"  => $card,
                "shaba" => $shaba,
            ]);

            return $this->sendResponse([
                "bank" => new BankResource($bank),
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}
