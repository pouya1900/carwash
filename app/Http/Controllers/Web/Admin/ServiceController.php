<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ServiceRequest;
use App\Models\Base_service;
use App\Models\Carwash;
use App\Models\Item;
use App\Models\Service;
use App\Models\Type;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function services(Carwash $carwash = null)
    {
        $admin = $this->request->admin;

        $services = Service::when($carwash, function ($q) use ($carwash) {
            return $q->where('carwash_id', $carwash->id);
        })->orderBy("created_at", "desc")->get();
        return view('admin.services.index', compact('admin', 'services', 'carwash'));
    }

    public function create(Carwash $carwash)
    {
        $admin = $this->request->admin;

        $base_services = Base_service::all();

        $items = Item::all();
        $types = Type::all();

        foreach ($base_services as $base_service) {
            $base_service->description_text = $base_service->descriptionText;
        }

        return view('admin.services.create', compact('admin', 'carwash', 'base_services', 'items', 'types'));
    }

    public function store(ServiceRequest $request, Carwash $carwash)
    {
        try {
            $admin = $this->request->admin;

            $service = $carwash->services()->create([
                "base_id"  => $request->input("base_service"),
                "status"   => $request->input("status") ? 1 : 0,
                "price"    => $request->input("price"),
                "discount" => $request->input("discount") ?? 0,
                "is_main"  => $request->input("is_main") ? 1 : 0,
            ]);

            if ($request->input("items")) {
                foreach ($request->input("items") as $item_id) {
                    $item = Item::find($item_id);
                    if ($item) {
                        $service->items()->attach($item);
                    }
                }
            }

            if ($request->input("types")) {
                foreach ($request->input("types") as $type_id) {
                    $type = Type::find($type_id);
                    if ($type) {
                        $service->types()->attach($type);
                    }
                }
            }
            return redirect(route('admin.services', $carwash->id))->with(['message' => trans('trs.service_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

    public function edit(Service $service)
    {
        $admin = $this->request->admin;

        $carwash = $service->carwash;

        $base_services = Base_service::all();

        $items = Item::all();
        $types = Type::all();

        foreach ($base_services as $base_service) {
            $base_service->description_text = $base_service->descriptionText;
        }

        $service->items = $service->items;
        $service->types = $service->types;

        return view('admin.services.edit', compact('admin', 'carwash', 'service', 'base_services', 'items', 'types'));

    }

    public function update(ServiceRequest $request, Service $service)
    {
        try {
            $admin = $this->request->admin;

            $carwash = $service->carwash;

            $service->update([
                "base_id"  => $request->input("base_service"),
                "status"   => $request->input("status") ? 1 : 0,
                "price"    => $request->input("price"),
                "discount" => $request->input("discount") ?? 0,
                "is_main"  => $request->input("is_main") ? 1 : 0,
            ]);

            $service->items()->detach();
            if ($request->input("items")) {
                foreach ($request->input("items") as $item_id) {
                    $item = Item::find($item_id);
                    if ($item) {
                        $service->items()->attach($item);
                    }
                }
            }

            $service->types()->detach();
            if ($request->input("types")) {
                foreach ($request->input("types") as $type_id) {
                    $type = Type::find($type_id);
                    if ($type) {
                        $service->types()->attach($type);
                    }
                }
            }

            return redirect(route('admin.services', $carwash->id))->with(['message' => trans('trs.service_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

    public function remove(Service $service)
    {
        try {
            $admin = $this->request->admin;

            $service->items()->detach();
            $service->types()->detach();
            $service->delete();

            return redirect(route('admin.services'))->with(['message' => trans('trs.service_removed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }
}
