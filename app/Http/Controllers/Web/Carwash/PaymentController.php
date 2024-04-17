<?php

namespace App\Http\Controllers\Web\Carwash;

use App\Http\Controllers\Controller;
use App\Models\Carwash;
use App\Models\Deposit;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function incomes()
    {
        $carwash = $this->request->current_carwash;

        return view('carwash.payments.income', compact('carwash'));
    }

    public function withdraws()
    {
        $carwash = $this->request->current_carwash;

        return view('carwash.payments.withdraw', compact('carwash'));
    }

    public function create()
    {
        $carwash = $this->request->current_carwash;

        return view('carwash.payments.create', compact('carwash'));
    }

    public function store()
    {
        try {
            $carwash = $this->request->current_carwash;

            $price = $this->request->input("price");
            $bank = $this->request->input("bank");

            if (intval($price) > $carwash->balance) {
                return redirect()->back()->withErrors(['error' => trans('trs.amount_is_more_than_balance')]);
            }

            if (!$carwash->banks()->where('id', $bank)->first()) {
                return redirect()->back()->withErrors(['error' => "بانک انتخاب نشده است."]);
            }

            if ($price <= 0) {
                return redirect()->back()->withErrors(['error' => "مبلغ نامعتبر است."]);
            }

            $carwash->deposits()->create([
                "bank_id" => $bank,
                "total"   => $price,
                "status"  => "requested",
                "message" => "",
            ]);

            $carwash->update([
                "balance" => $carwash->balance - $price,
            ]);

            return redirect(route('carwash_withdraws'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function delete(Deposit $deposit)
    {
        try {
            $carwash = $this->request->current_carwash;

            if ($carwash->id != $deposit->depositable->id || !$deposit->depositable instanceof Carwash) {
                abort(403);
            }

            if ($deposit->status != "requested") {
                return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
            }

            $price = $deposit->total;

            $deposit->delete();

            $carwash->update([
                "balance" => $carwash->balance + $price,
            ]);

            return redirect(route('carwash_withdraws'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

}
