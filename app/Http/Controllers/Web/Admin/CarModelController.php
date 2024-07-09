<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\StoreModelRequest;
use App\Models\Brand;
use App\Models\Car_model;
use App\Models\Type;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    use UploadUtilsTrait;

    public function index()
    {
        $admin = $this->request->admin;

        $models = Car_model::all();

        return view('admin.models.index', compact('admin', 'models'));

    }

    public function create()
    {
        $admin = $this->request->admin;

        $brands = Brand::all();
        $types = Type::all();

        return view('admin.models.create', compact('admin', 'brands', 'types'));
    }

    public function store(StoreModelRequest $request)
    {
        try {
            $model = Car_model::create([
                'title'       => $request->input('title'),
                'brand_id'    => $request->input('brand'),
                'type_id'     => $request->input('type'),
                'description' => $request->input('description') ?? "",
            ]);

            if ($request->input('deleted_image_logo')) {
                $logo = $model->logo["model"];
                if ($logo) {
                    $this->mediaRemove($logo, 'assetsStorage');
                }
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $this->imageUpload($logo, 'carModelLogo', 'assetsStorage', $model);
            }

            return redirect(route('admin.models'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function edit(Car_model $model)
    {
        $admin = $this->request->admin;

        $brands = Brand::all();
        $types = Type::all();

        return view('admin.models.edit', compact('admin', 'model', 'brands', 'types'));
    }

    public function update(Car_model $model, StoreModelRequest $request)
    {
        try {
            $model->update([
                'title'       => $request->input('title'),
                'brand_id'    => $request->input('brand'),
                'type_id'     => $request->input('type'),
                'description' => $request->input('description') ?? "",
            ]);

            if ($request->input('deleted_image_logo')) {
                $logo = $model->logo["model"];
                if ($logo) {
                    $this->mediaRemove($logo, 'assetsStorage');
                }
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $this->imageUpload($logo, 'carModelLogo', 'assetsStorage', $model);
            }

            return redirect(route('admin.models'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function remove(Car_model $model)
    {
        try {
            $model->delete();
            return redirect(route('admin.models'))->with('message', trans('trs.changed_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }
}
