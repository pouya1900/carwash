<?php

namespace App\Http\Controllers\Web\Carwash;

use App\Http\Controllers\Controller;
use App\Models\Carwash;
use App\Models\Reservation;
use App\Models\Setting;
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

    public function update(Reservation $reservation)
    {
        try {
            $carwash = $this->request->current_carwash;
            $setting = Setting::first();

            if ($carwash->id != $reservation->carwash->id) {
                return abort(403);
            }

            if ($reservation->status != "doing") {
                return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
            }

            $reservation->update([
                "status" => "finished",
            ]);

            $commission = $setting->service_commission * $reservation->price / 100;
            $paid = $reservation->price - $commission;

            $carwash->update([
                "balance" => $carwash->balance + $paid,
            ]);

            $carwash->releases()->create([
                "reservation_id" => $reservation->id,
                "total"          => $reservation->price,
                "paid"           => $paid,
                "commission"     => $commission,
                "balance"        => $carwash->balance,
            ]);

            return redirect(route('carwash_reservations'))->with(['message' => trans('trs.reservation_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

}
