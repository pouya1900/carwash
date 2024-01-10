<?php

namespace App\Http\Controllers;

use App\Traits\ResponseUtilsTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ResponseUtilsTrait;

    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function validateRequest(array $requestData, array $rules)
    {
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            $this->sendError($validator->errors()->first());
        }
    }

    protected function getPerPage()
    {
        return $this->request->input("perPage") ?: 10;
    }

}
