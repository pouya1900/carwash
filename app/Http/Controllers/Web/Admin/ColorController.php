<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\StoreColorRequest;
use App\Models\color;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    use UploadUtilsTrait;

    public function index()
    {
        $admin = $this->request->admin;

        $colors = Color::all();

        return view('admin.colors.index', compact('admin', 'colors'));

    }

    public function create()
    {
        $admin = $this->request->admin;

        return view('admin.colors.create', compact('admin'));
    }

    public function store(StoreColorRequest $request)
    {
        try {
            $color = Color::create([
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            return redirect(route('admin.colors'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function edit(Color $color)
    {
        $admin = $this->request->admin;

        return view('admin.colors.edit', compact('admin', 'color'));
    }

    public function update(Color $color, StoreColorRequest $request)
    {
        try {
            $color->update([
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            return redirect(route('admin.colors'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function remove(Color $color)
    {
        try {
            $color->delete();
            return redirect(route('admin.colors'))->with('message', trans('trs.changed_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

}
