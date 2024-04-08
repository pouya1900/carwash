<?php

namespace App\Http\Controllers\Servant;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function incomes()
    {
        $servant = $this->request->current_servant;

        return view('servant.payments.income', compact('servant'));
    }

    public function withdraws()
    {
        $servant = $this->request->current_servant;

        return view('servant.payments.withdraw', compact('servant'));
    }

    public function create()
    {
        $servant = $this->request->current_servant;

        return view('servant.payments.create', compact('servant'));
    }

    public function store()
    {
        try {
            $servant = $this->request->current_servant;

            $price = $this->request->input("price");
            $bank = $this->request->input("bank");

            if (intval($price) > $servant->balance) {
                return redirect()->back()->withErrors(['error' => trans('trs.amount_is_more_than_balance')]);
            }

            if (!$servant->banks()->where('id', $bank)->first()) {
                return redirect()->back()->withErrors(['error' => "بانک انتخاب نشده است."]);
            }

            if ($price <= 0) {
                return redirect()->back()->withErrors(['error' => "مبلغ نامعتبر است."]);
            }

            $servant->deposits()->create([
                "bank_id" => $bank,
                "total"   => $price,
                "status"  => "requested",
            ]);

            $servant->update([
                "balance" => $servant->balance - $price,
            ]);

            return redirect(route('servant_withdraws'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function delete(Deposit $deposit)
    {
        try {
            $servant = $this->request->current_servant;

            if ($servant->id != $deposit->servant->id) {
                abort(403);
            }

            if ($deposit->status != "requested") {
                return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
            }

            $price = $deposit->total;

            $deposit->delete();

            $servant->update([
                "balance" => $servant->balance + $price,
            ]);

            return redirect(route('servant_withdraws'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

}
