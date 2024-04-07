<?php

namespace App\Http\Controllers\Web\Payment;

use App\Events\SendPushNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\Payment\PaymentGateway;
use App\Services\Payment\Zarinpal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class PaymentController extends Controller
{

    public function verifyBalance(Payment $payment)
    {
        $ref_id = 0;
        $amount = $payment->online;

        try {

            if ($payment->status != "pending") {
                $ref_id = $payment->ref_id;
                return view('webViews.payment_result', compact('ref_id', 'amount'));
            }

            $status = $this->request->input("Status");
            $authority = $this->request->input("Authority");
            $payment_instance = new PaymentGateway(new Zarinpal());

            $response = $payment_instance->verifyPayment($status, $authority, $payment->online);

            if ($response["status"] == 2) {
                $payment->update([
                    "status" => "failed",
                ]);
                return view('webViews.payment_result', compact('ref_id', 'amount'));
            } elseif ($response["status"] == 1) {
                $ref_id = $response["ref_id"];
                return view('webViews.payment_result', compact('ref_id', 'amount'));
            }

            $ref_id = $response["ref_id"];

            $payment->update([
                "status" => "completed",
                "ref_id" => $ref_id,
            ]);

            $user = $payment->user;
            $user->update([
                "balance" => $user->balance + $payment->online,
            ]);

            return view('webViews.payment_result', compact('ref_id', 'amount'));

        } catch (\Exception $e) {
            return view('webViews.payment_result', compact('ref_id', 'amount'));
        }
    }

    public function verifyReserve(Payment $payment)
    {
        $ref_id = 0;
        $amount = $payment->online;

        try {
            $setting = Setting::first();
            $user = $payment->user;

            if ($payment->status != "pending") {
                $ref_id = $payment->ref_id;
                return view('webViews.payment_result', compact('ref_id', 'amount'));
            }

            if ($user->balance < $payment->wallet) {
                $payment->update([
                    "status" => "failed",
                ]);
                return view('webViews.payment_result', compact('ref_id', 'amount'));
            }
            if ($payment->online > 0) {
                $status = $this->request->input("Status");
                $authority = $this->request->input("Authority");


                $payment_instance = new PaymentGateway(new Zarinpal());

                $response = $payment_instance->verifyPayment($status, $authority, $payment->online);

                if ($response["status"] == 2) {
                    $payment->update([
                        "status" => "failed",
                    ]);
                    return view('webViews.payment_result', compact('ref_id', 'amount'));
                } elseif ($response["status"] == 1) {
                    $ref_id = $response["ref_id"];
                    return view('webViews.payment_result', compact('ref_id', 'amount'));
                }
                $ref_id = $response["ref_id"];
            }

            if (!$ref_id) {
                $ref_id = 1;
            }


            $payment->update([
                "status" => "completed",
                "ref_id" => $ref_id,
            ]);

            $user->update([
                "balance"      => $user->balance - $payment->wallet,
                "gift_balance" => max($user->gift_balance - $payment->wallet, 0),
            ]);

            if ($gift = $user->gifts()->where("status", "pending")->first()) {
                $gift->update([
                    "number" => $gift->number + 1,
                    "status" => $gift->number + 1 == $gift->total ? "completed" : "pending",
                ]);
            } else {
                $user->gifts()->create([
                    "number" => 1,
                    "total"  => $setting->gift_number,
                    "value"  => $setting->gift_value,
                    "status" => "pending",
                ]);
            }

            $reservations = $payment->reservations;

            foreach ($reservations as $reservation) {
                $reservation->update([
                    "status" => "approved",
                ]);
            }
            $ref_id = $response["ref_id"];
            $amount = $payment->online;

//            its temporary
            Event::dispatch(new SendPushNotificationEvent($user->firebase_token, "رزرو", "رزرو انجام شد."));
//            its temporary


            return view('webViews.payment_result', compact('ref_id', 'amount'));

        } catch (\Exception $e) {
            return view('webViews.payment_result', compact('ref_id', 'amount'));
        }
    }
}
