<?php

namespace App\Http\Controllers;

use App\Traits\ResponseUtilsTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ResponseUtilsTrait;

    protected function validateRequest(array $requestData, array $rules)
    {
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            $this->sendError($validator->errors()->first());
        }
    }

}
