<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\StoreTypeRequest;
use App\Models\Type;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{

    use UploadUtilsTrait;

    public function index()
    {
        $admin = $this->request->admin;

        $types = Type::all();

        return view('admin.types.index', compact('admin', 'types'));

    }

    public function create()
    {
        $admin = $this->request->admin;

        return view('admin.types.create', compact('admin'));
    }

    public function store(StoreTypeRequest $request)
    {
        try {
            $type = Type::create([
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            if ($request->input('deleted_image_logo')) {
                $logo = $type->logo["model"];
                if ($logo) {
                    $this->mediaRemove($logo, 'assetsStorage');
                }
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $this->imageUpload($logo, 'typeLogo', 'assetsStorage', $type);
            }

            return redirect(route('admin.types'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function edit(Type $type)
    {
        $admin = $this->request->admin;

        return view('admin.types.edit', compact('admin', 'type'));
    }

    public function update(Type $type, StoreTypeRequest $request)
    {
        try {
            $type->update([
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            if ($request->input('deleted_image_logo')) {
                $logo = $type->logo["model"];
                if ($logo) {
                    $this->mediaRemove($logo, 'assetsStorage');
                }
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $this->imageUpload($logo, 'typeLogo', 'assetsStorage', $type);
            }

            return redirect(route('admin.types'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function remove(Type $type)
    {
        try {
            $type->delete();
            return redirect(route('admin.types'))->with('message', trans('trs.changed_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

}
