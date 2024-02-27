<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    public function index()
    {

    }

    public function store()
    {
        $amount = $this->request->input("amount");
        $bank= $this->request->input("bank");

    }

}
