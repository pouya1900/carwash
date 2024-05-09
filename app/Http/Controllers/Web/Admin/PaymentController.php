<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\SubmitNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Carwash;
use App\Models\Deposit;
use App\Models\Payment;
use App\Models\Release;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class PaymentController extends Controller
{
    public function payments()
    {
        $admin = $this->request->admin;

        $user = $this->request->input('user');
        $carwash = $this->request->input('carwash');

        $payments = Payment::when($user, function ($q) use ($user) {
            return $q->where('user_id', $user);
        })->when($carwash, function ($q) use ($carwash) {
            return $q->wherehas('reservation', function ($q) use ($carwash) {
                return $q->where('carwash_id', $carwash);
            });
        })->orderBy("created_at", "desc")->get();

        $user = User::find($user);
        $carwash = Carwash::find($carwash);

        return view('admin.payments.payments', compact('admin', 'payments', 'user', 'carwash'));

    }

    public function releases()
    {
        $admin = $this->request->admin;

        $carwash = $this->request->input('carwash');

        $releases = Release::when($carwash, function ($q) use ($carwash) {
            return $q->where('carwash_id', $carwash);
        })->orderBy("created_at", "desc")->get();

        $carwash = Carwash::find($carwash);

        return view('admin.payments.releases', compact('admin', 'releases', 'carwash'));

    }

    public function deposits()
    {
        $admin = $this->request->admin;

        $carwash = $this->request->input('carwash');
        $user = $this->request->input('user');

        $carwash_deposits = Deposit::when($carwash, function ($q) use ($carwash) {
            return $q->where('depositable_id', $carwash);
        })->where("depositable_type", Carwash::class)->orderBy("created_at", "desc")->get();

        $user_deposits = Deposit::when($user, function ($q) use ($user) {
            return $q->where('depositable_id', $user);
        })->where("depositable_type", User::class)->orderBy("created_at", "desc")->get();


        $carwash = Carwash::find($carwash);
        $user = User::find($user);

        return view('admin.payments.deposits', compact('admin', 'carwash_deposits', 'user_deposits', 'carwash', 'user'));
    }

    public function edit_deposit(Deposit $deposit)
    {
        $admin = $this->request->admin;

        if ($deposit->status == "rejected") {
            abort(403);
        }

        return view('admin.payments.edit_deposit', compact('admin', 'deposit'));
    }

    public function update_deposit(Deposit $deposit)
    {
        try {

            if ($deposit->status == "rejected") {
                abort(403);
            }

            $deposit->update([
                "status"  => $this->request->input("status"),
                "message" => $this->request->input("message") ?? "",
            ]);

            if ($this->request->input("status") == "rejected") {
                $deposit->servant->update([
                    "balance" => $deposit->carwash->balance + $deposit->total,
                ]);
            }
            $notification_message = "درخواست برداشت شما توسط ادمین بررسی شد.";

            Event::dispatch(new SubmitNotificationEvent($notification_message, $deposit->servant));


            return redirect(route('admin.deposits'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }
}
