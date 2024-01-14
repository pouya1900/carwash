<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Resources\AppViewResource;
use App\Models\App_view;
use App\Traits\ResponseUtilsTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    use ResponseUtilsTrait;

    public function index()
    {
        try {
            $number = $this->request->number;
            $app_views = App_view::where("status", "active")->orderBy("order", "asc")->get();

            $app_views->number = $number;
            return $this->sendResponse([
                'views' => AppViewResource::collection($app_views),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}
