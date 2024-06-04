<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carwash;
use App\Models\Reservation;
use App\Models\Setting;
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

    public function update(Reservation $reservation)
    {
        try {
            $admin = $this->request->admin;

            $carwash = $reservation->carwash;
            $setting = Setting::first();

            if ($reservation->status != "doing" && $reservation->status != "approved") {
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

            return redirect(route('admin.reservations'))->with(['message' => trans('trs.reservation_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }


}
