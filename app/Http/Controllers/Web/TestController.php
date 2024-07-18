<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Activation;

class TestController extends Controller
{

    public function index()
    {
        $activations = Activation::all();
        dd($activations);
    }

}
