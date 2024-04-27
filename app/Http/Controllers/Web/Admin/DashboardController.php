<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Deposit;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Release;
use App\Models\Reservation;
use App\Models\Carwash;
use App\Models\User;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = $this->request->admin;

        $carwashes = Carwash::all();
        $users = User::all();


        $start = $this->request->input("start");
        $end = $this->request->input("end");

        $start_date = null;
        $end_date = null;
        if ($start && $end) {
            $start_date = Jalalian::fromFormat('Y/m/d', $start)->toCarbon();
            $end_date = Jalalian::fromFormat('Y/m/d', $end)->toCarbon();
        }
        $users_total_balance = User::sum("balance");

        $carwashes_total_balance = Carwash::sum("balance");


        $users_total_payment = Payment::where("status", "completed")->when($start_date, function ($q) use ($start_date, $end_date) {
            return $q->whereBetween("created_at", [$start_date, $end_date]);
        })->sum("online");

        $carwashes_total_income = Release::when($start_date, function ($q) use ($start_date, $end_date) {
            return $q->whereBetween("created_at", [$start_date, $end_date]);
        })->sum("paid");

        $system_total_income = Release::when($start_date, function ($q) use ($start_date, $end_date) {
            return $q->whereBetween("created_at", [$start_date, $end_date]);
        })->sum("commission");

        $carwashes_total_deposit = Deposit::where("status", "completed")->when($start_date, function ($q) use ($start_date, $end_date) {
            return $q->whereBetween("created_at", [$start_date, $end_date]);
        })->sum("total");


        return view('admin.dashboard.index', compact('admin', 'carwashes', 'users', 'users_total_payment', 'users_total_balance', 'carwashes_total_balance', 'carwashes_total_income', 'system_total_income', 'carwashes_total_deposit', 'start', 'end'));
    }
}
