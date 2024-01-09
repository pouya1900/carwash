<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AppViewResource;
use App\Models\App_view;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

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
