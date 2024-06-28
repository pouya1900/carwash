<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\BaseServiceRequest;
use App\Http\Requests\Web\ServiceRequest;
use App\Models\Base_service;
use Illuminate\Http\Request;

class BaseServiceController extends Controller
{
    public function index()
    {
        $admin = $this->request->admin;

        $services = Base_service::orderBy("created_at", "desc")->get();

        return view('admin.base_services.index', compact('admin', 'services'));
    }

    public function create()
    {
        $admin = $this->request->admin;

        return view('admin.base_services.create', compact('admin'));
    }

    public function store(BaseServiceRequest $request)
    {
        try {
            $admin = $this->request->admin;

            $service = Base_service::create([
                "title"       => $request->input("title"),
                "description" => $request->input("description"),
                "is_main"     => $request->input("is_main") ? 1 : 0,
            ]);

            return redirect(route('admin.base_services'))->with(['message' => trans('trs.service_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

    public function edit(Base_service $service)
    {
        $admin = $this->request->admin;

        return view('admin.base_services.edit', compact('admin', 'service'));

    }

    public function update(BaseServiceRequest $request, Base_service $service)
    {
        try {
            $admin = $this->request->admin;

            $service->update([
                "title"       => $request->input("title"),
                "description" => $request->input("description"),
                "is_main"     => $request->input("is_main") ? 1 : 0,
            ]);

            return redirect(route('admin.base_services'))->with(['message' => trans('trs.service_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

    public function remove(Base_service $service)
    {
        try {
            $admin = $this->request->admin;

            $service->delete();

            return redirect(route('admin.base_services'))->with(['message' => trans('trs.service_removed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }
}
