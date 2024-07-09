<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\StoreBrandRequest;
use App\Models\Brand;
use App\Models\Type;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    use UploadUtilsTrait;

    public function index()
    {
        $admin = $this->request->admin;

        $brands = Brand::all();

        return view('admin.brands.index', compact('admin', 'brands'));

    }

    public function create()
    {
        $admin = $this->request->admin;

        $types = Type::all();

        return view('admin.brands.create', compact('admin', 'types'));
    }

    public function store(StoreBrandRequest $request)
    {
        try {
            $types = $request->input("types");
            $brand = Brand::create([
                'title'       => $request->input('title'),
                'description' => $request->input('description') ?? "",
            ]);

            if ($request->input('deleted_image_logo')) {
                $logo = $brand->logo["model"];
                if ($logo) {
                    $this->mediaRemove($logo, 'assetsStorage');
                }
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $this->imageUpload($logo, 'brandLogo', 'assetsStorage', $brand);
            }

            if ($types) {
                foreach ($types as $type) {
                    $brand->types()->attach($type);
                }
            }

            return redirect(route('admin.brands'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function edit(Brand $brand)
    {
        $admin = $this->request->admin;

        $types = Type::all();

        return view('admin.brands.edit', compact('admin', 'brand', 'types'));
    }

    public function update(Brand $brand, StoreBrandRequest $request)
    {
        try {
            $types = $request->input("types");

            $brand->update([
                'title'       => $request->input('title'),
                'description' => $request->input('description') ?? "",
            ]);

            if ($request->input('deleted_image_logo')) {
                $logo = $brand->logo["model"];
                if ($logo) {
                    $this->mediaRemove($logo, 'assetsStorage');
                }
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $this->imageUpload($logo, 'brandLogo', 'assetsStorage', $brand);
            }

            $brand->types()->detach();
            if ($types) {
                foreach ($types as $type) {
                    $brand->types()->attach($type);
                }
            }
            return redirect(route('admin.brands'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function remove(Brand $brand)
    {
        try {
            $brand->delete();
            return redirect(route('admin.brands'))->with('message', trans('trs.changed_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }
}
