<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Http\Resources\StateResource;
use App\Models\State;
use App\Traits\ResponseUtilsTrait;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    use ResponseUtilsTrait;

    public function states()
    {
        try {

            $states = State::all();

            return $this->sendResponse([
                "states" => StateResource::collection($states),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


}
