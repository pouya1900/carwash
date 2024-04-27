<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\UpdateCarwashRequest;
use App\Models\Carwash;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class CarwashController extends Controller
{
    use UploadUtilsTrait;

    public function index()
    {
        $admin = $this->request->admin;

        $carwashes = Carwash::orderBy("created_at", "desc")->get();

        return view('admin.carwashes.index', compact('admin', 'carwashes'));
    }

    public function edit(Carwash $carwash)
    {
        $admin = $this->request->admin;
        return view('admin.carwashes.edit', compact('carwash', 'admin'));

    }

    public function update(UpdateCarwashRequest $request, Carwash $carwash)
    {
        try {

            $carwash->update([
                'title'   => $request->input('title'),
                'mobile'  => $request->input('mobile'),
                'address' => $request->input('address'),
                'balance' => $request->input('balance'),
                'status'  => $request->input('status'),
            ]);

            if ($this->request->input('deleted_image_logo')) {
                $this->mediaRemove($carwash->logo['model'], 'assetsStorage');
            }

            if ($this->request->hasFile('logo')) {
                $logo = $this->request->file('logo');

                $this->imageUpload($logo, 'carwashLogo', 'assetsStorage', $carwash);
            }

            return redirect(route('admin.carwashes'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

}
