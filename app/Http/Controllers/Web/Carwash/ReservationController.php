<?php

namespace App\Http\Controllers\Web\Carwash;

use App\Http\Controllers\Controller;
use App\Models\Carwash;
use App\Models\Reservation;
use App\Traits\UploadUtilsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class ReservationController extends Controller
{
    use UploadUtilsTrait;

    public function index()
    {
        $carwash = $this->request->current_carwash;
        $reservations = $carwash->reservations()->selectraw("reservations.* , time_tables.start")->where("status", "!=", "created")->join('time_tables', 'time_tables.reservation_id', 'reservations.id')->orderBy("time_tables.start", "desc")->get();

        return view('carwash.reservations.index', compact('carwash', 'reservations'));
    }

}
