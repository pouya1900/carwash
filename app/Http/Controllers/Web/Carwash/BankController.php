<?php

namespace App\Http\Controllers\Web\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\bankStoreRequest;
use App\Models\Bank;
use App\Models\Carwash;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $carwash = $this->request->current_carwash;

        $banks = $carwash->banks;

        return view('carwash.banks.index', compact('banks', 'carwash'));
    }

    public function create()
    {
        $carwash = $this->request->current_carwash;

        return view('carwash.banks.create', compact('carwash'));
    }

    public function store(bankStoreRequest $request)
    {
        try {
            $name = $request->input('name');
            $card = $request->input('card');
            $shaba = $request->input('shaba');
            $carwash = $this->request->current_carwash;

            $bank = $carwash->banks()->create([
                'name'  => $name,
                'card'  => $card,
                'shaba' => $shaba,
            ]);
            return redirect(route('carwash_banks'))->with(['message' => trans('trs.bank_saved_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }

    }

    public function edit(Bank $bank)
    {
        $carwash = $this->request->current_carwash;

        if ($carwash->id != $bank->bankable->id || !$bank->bankable instanceof Carwash) {
            return abort('403');
        }

        return view('carwash.banks.edit', compact('bank', 'carwash'));
    }

    public function update(Bank $bank, bankStoreRequest $request)
    {
        try {

            $name = $request->input('name');
            $card = $request->input('card');
            $shaba = $request->input('shaba');
            $carwash = $this->request->current_carwash;

            if ($carwash->id != $bank->bankable->id || !$bank->bankable instanceof Carwash) {
                return abort('403');
            }

            $bank->update([
                'name'  => $name,
                'card'  => $card,
                'shaba' => $shaba,
            ]);
            return redirect(route('carwash_banks'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function delete(Bank $bank)
    {
        try {
            $carwash = $this->request->current_carwash;

            if ($carwash->id != $bank->bankable->id || !$bank->bankable instanceof Carwash) {
                return abort('403');
            }

            $bank->delete();

            return redirect(route('carwash_banks'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }
}
