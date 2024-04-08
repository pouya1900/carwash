<?php

namespace App\Http\Controllers\Servant;

use App\Http\Controllers\Controller;
use App\Http\Requests\bankStoreRequest;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $servant = $this->request->current_servant;

        $banks = $servant->banks;

        return view('servant.banks.index', compact('banks', 'servant'));
    }

    public function create()
    {
        $servant = $this->request->current_servant;

        return view('servant.banks.create', compact('servant'));
    }

    public function store(bankStoreRequest $request)
    {
        try {
            $name = $request->input('name');
            $card = $request->input('card');
            $shaba = $request->input('shaba');
            $servant = $this->request->current_servant;

            $bank = $servant->banks()->create([
                'name'  => $name,
                'card'  => $card,
                'shaba' => $shaba,
            ]);
            return redirect(route('servant_banks'))->with(['message' => trans('trs.bank_saved_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }

    }

    public function edit(Bank $bank)
    {
        $servant = $this->request->current_servant;

        if ($servant->id != $bank->servant->id) {
            abort('403');
        }

        return view('servant.banks.edit', compact('bank', 'servant'));
    }

    public function update(Bank $bank, bankStoreRequest $request)
    {
        try {

            $name = $request->input('name');
            $card = $request->input('card');
            $shaba = $request->input('shaba');
            $servant = $this->request->current_servant;

            if ($servant->id != $bank->servant->id) {
                abort('403');
            }

            $bank->update([
                'name'  => $name,
                'card'  => $card,
                'shaba' => $shaba,
            ]);
            return redirect(route('servant_banks'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function delete(Bank $bank)
    {
        try {
            $servant = $this->request->current_servant;

            if ($servant->id != $bank->servant->id) {
                abort('403');
            }

            $bank->delete();

            return redirect(route('servant_banks'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }
}
