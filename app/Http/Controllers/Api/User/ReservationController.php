<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Traits\ResponseUtilsTrait;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use ResponseUtilsTrait;

    public function reservations()
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
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


}
