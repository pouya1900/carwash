<?php

namespace App\Http\Controllers\Web\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ServiceRequest;
use App\Models\Base_service;
use App\Models\Category;
use App\Models\Item;
use App\Models\carwash;
use App\Models\Service;
use App\Models\Type;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function services()
    {
        $carwash = $this->request->current_carwash;

        return view('carwash.services.index', compact('carwash'));
    }

    public function create()
    {
        $carwash = $this->request->current_carwash;

        $base_services = Base_service::all();

        $items = Item::all();
        $types = Type::all();

        foreach ($base_services as $base_service) {
            $base_service->description_text = $base_service->descriptionText;
        }

        return view('carwash.services.create', compact('carwash', 'base_services', 'items', 'types'));
    }

    public function store(ServiceRequest $request)
    {
        try {
            $carwash = $this->request->current_carwash;

            $service = $carwash->services()->create([
                "base_id"  => $request->input("base_service"),
                "status"   => $request->input("status") ? 1 : 0,
                "price"    => $request->input("price"),
                "discount" => $request->input("discount") ?? 0,
                "is_main"  => $request->input("is_main") ? 1 : 0,
            ]);

            foreach ($request->input("items") as $item_id) {
                $item = Item::find($item_id);
                if ($item) {
                    $service->items()->attach($item);
                }
            }

            foreach ($request->input("types") as $type_id) {
                $type = Type::find($type_id);
                if ($type) {
                    $service->types()->attach($type);
                }
            }

            return redirect(route('carwash_services'))->with(['message' => trans('trs.service_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

    public function edit(Service $service)
    {
        $carwash = $this->request->current_carwash;

        if ($carwash->id != $service->carwash->id) {
            return abort(403);
        }

        $base_services = Base_service::all();

        $items = Item::all();
        $types = Type::all();

        foreach ($base_services as $base_service) {
            $base_service->description_text = $base_service->descriptionText;
        }

        $service->items=$service->items;
        $service->types=$service->types;

        return view('carwash.services.edit', compact('carwash', 'service', 'base_services', 'items', 'types'));

    }

    public function update(ServiceRequest $request, Service $service)
    {
        try {
            $carwash = $this->request->current_carwash;

            if ($carwash->id != $service->carwash->id) {
                return abort(403);
            }
            $service->update([
                "base_id"  => $request->input("base_service"),
                "status"   => $request->input("status") ? 1 : 0,
                "price"    => $request->input("price"),
                "discount" => $request->input("discount") ?? 0,
                "is_main"  => $request->input("is_main") ? 1 : 0,
            ]);

            $service->items()->detach();
            foreach ($request->input("items") as $item_id) {
                $item = Item::find($item_id);
                if ($item) {
                    $service->items()->attach($item);
                }
            }

            $service->types()->detach();
            foreach ($request->input("types") as $type_id) {
                $type = Type::find($type_id);
                if ($type) {
                    $service->types()->attach($type);
                }
            }

            return redirect(route('carwash_services'))->with(['message' => trans('trs.service_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

    public function remove(Service $service)
    {
        try {
            $carwash = $this->request->current_carwash;

            if ($carwash->id != $service->carwash->id) {
                return abort(403);
            }

            $service->items()->detach();
            $service->types()->detach();
            $service->delete();

            return redirect(route('carwash_services'))->with(['message' => trans('trs.service_removed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

}
