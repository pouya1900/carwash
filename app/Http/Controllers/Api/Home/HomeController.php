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
        $number = $this->request->number;


        $app_views = App_view::where("status", "active")->get();

        $app_views->number = $number;


        return $this->sendResponse([
            'views' => AppViewResource::collection($app_views),
        ]);

    }

}
