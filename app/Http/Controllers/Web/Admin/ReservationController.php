<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carwash;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Carwash $carwash = null)
    {
        $admin = $this->request->admin;

        $reservations = Reservation::selectraw("reservations.* , time_tables.start")
            ->when($carwash, function ($q) use ($carwash) {
                return $q->where('carwash_id', $carwash->id);
            })->where("status", "!=", "created")->join('time_tables', 'time_tables.reservation_id', 'reservations.id')->orderBy("time_tables.start", "desc")->get();

        return view('admin.reservations.index', compact('admin', 'carwash', 'reservations'));
    }
}
