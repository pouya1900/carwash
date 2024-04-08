<?php

namespace App\Http\Controllers\Servant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Category;
use App\Models\Insurance;
use App\Models\Servant;
use App\Models\Service;
use App\Models\Tariff;
use App\Models\Unit;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function services()
    {
        $servant = $this->request->current_servant;

        return view('servant.services.index', compact('servant'));
    }

    public function create()
    {
        $servant = $this->request->current_servant;

        $categories = Category::whereNull('parent_id')->with('children')->get();
        $units = Unit::all();

        $insurances = Insurance::all();

        $children = $servant->accepted("children")->get();
        foreach ($children as $child) {
            $child->full_name = $child->fullName;
        }

        $servant->addresses = $servant->addresses;

        $parents_place = $servant->accepted("parents")->where("is_place", 1)->with('addresses')->get();

        return view('servant.services.create', compact('servant', 'categories', 'units', 'insurances', 'children', 'parents_place'));
    }

    public function store(ServiceRequest $request)
    {
        try {
            $servant = $this->request->current_servant;

            $title = $request->input('title');
            $description = $request->input('description');
            $category = $request->input('category');
            $time = $request->input('time');
            $type = $request->input('type');
            $price = $request->input('price');

            $insurances = $request->input('insurances');
            $insurances_type = $request->input('insurances_type');
            $insurances_value = $request->input('insurances_value');

            $team = $request->input('team');
            $member_title = $request->input('member_title');
            $member_share = $request->input('member_share');

            $address_id = $request->input('place');


            $service = $servant->services()->create([
                'title'       => $title,
                'description' => $description,
                'type'        => $type,
                'category_id' => $category,
                'time'        => $time,
                'base_price'  => $price,
                'address_id'  => $address_id ?: null,
            ]);

            $attr_title = $request->input('attr_title');
            $attr_type = $request->input('attr_type');
            $attr_price = $request->input('attr_price');
            $attr_unit = $request->input('attr_unit');
            $attr = $request->input('attr');

            if ($attr_title) {
                for ($i = 0; $i < count($attr_title); $i++) {

                    $attribute = [];
                    $attribute["title"] = $attr_title[$i];
                    $attribute["type"] = $attr_type[$i];
                    $options = null;

                    if ($attribute["type"] == 1) {
                        $attribute["fee"] = $attr_price[$i];
                        $attribute["unit_id"] = $attr_unit[$i];
                    } else {
                        $options = [];
                        for ($j = 0; $j < count($attr[$i]['title']); $j++) {
                            $options[] = ["title" => $attr[$i]['title'][$j], "fee" => $attr[$i]['price'][$j]];
                        }
                        $options = json_encode($options);
                    }

                    $attribute['option'] = $options;

                    $service->attributes()->create($attribute);
                }
            }

            if ($insurances) {
                foreach ($insurances as $key => $insurance) {
                    $service->insurances()->attach($insurance, ['type' => $insurances_type[$key], 'value' => $insurances_value[$key]]);
                }
            }

            if ($team) {
                foreach ($team as $key => $member) {
                    $title = $member_title[$key];
                    $share = $member_share[$key];
                    $service->teamMembers()->attach($member, ["title" => $title, "share" => $share]);
                }
            }

            return redirect(route('servant_services'))->with(['message' => trans('trs.service_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

    public function edit(Service $service)
    {
        $servant = $this->request->current_servant;

        if ($servant->id != $service->servant->id) {
            abort(403);
        }

        $categories = Category::whereNull('parent_id')->with('children')->get();
        $units = Unit::all();

        $insurances = Insurance::all();

        $children = $servant->accepted("children")->get();
        foreach ($children as $child) {
            $child->full_name = $child->fullName;
        }

        $service->category = $service->category;
        $service->category->parent = $service->category->parent;
        $service->insurances = $service->insurances;
        $service->attributes = $service->attributes;
        $service->teamMembers = $service->teamMembers;
        $servant->addresses = $servant->addresses;

        $parents_place = $servant->accepted("parents")->where("is_place", 1)->with('addresses')->get();


        return view('servant.services.edit', compact('servant', 'service', 'categories', 'units', 'insurances', 'children', 'parents_place'));

    }

    public function update(ServiceRequest $request, Service $service)
    {
        try {
            $servant = $this->request->current_servant;

            if ($servant->id != $service->servant->id) {
                abort(403);
            }

            $title = $request->input('title');
            $description = $request->input('description');
            $category = $request->input('category');
            $time = $request->input('time');
            $type = $request->input('type');
            $price = $request->input('price');
            $address_id = $request->input('place');

            $insurances = $request->input('insurances');
            $insurances_type = $request->input('insurances_type');
            $insurances_value = $request->input('insurances_value');

            $team = $request->input('team');
            $member_title = $request->input('member_title');
            $member_share = $request->input('member_share');

            $service->update([
                'title'       => $title,
                'description' => $description,
                'type'        => $type,
                'category_id' => $category,
                'time'        => $time,
                'base_price'  => $price,
                'address_id'  => $address_id ?: null,
            ]);

            $attr_title = $request->input('attr_title');
            $attr_type = $request->input('attr_type');
            $attr_price = $request->input('attr_price');
            $attr_unit = $request->input('attr_unit');
            $attr = $request->input('attr');

            $service->attributes()->delete();
            $service->insurances()->detach();
            $service->teamMembers()->detach();

            if ($attr_title) {
                for ($i = 0; $i < count($attr_title); $i++) {

                    $attribute = [];
                    $attribute["title"] = $attr_title[$i];
                    $attribute["type"] = $attr_type[$i];
                    $options = null;

                    if ($attribute["type"] == 1) {
                        $attribute["fee"] = $attr_price[$i];
                        $attribute["unit_id"] = $attr_unit[$i];
                    } else {
                        $options = [];
                        for ($j = 0; $j < count($attr[$i]['title']); $j++) {
                            $options[] = ["title" => $attr[$i]['title'][$j], "fee" => $attr[$i]['price'][$j]];
                        }
                        $options = json_encode($options);
                    }

                    $attribute['option'] = $options;

                    $service->attributes()->create($attribute);
                }
            }

            if ($insurances) {
                foreach ($insurances as $key => $insurance) {
                    $service->insurances()->attach($insurance, ['type' => $insurances_type[$key], 'value' => $insurances_value[$key]]);
                }
            }

            if ($team) {
                foreach ($team as $key => $member) {
                    $title = $member_title[$key];
                    $share = $member_share[$key];
                    $service->teamMembers()->attach($member, ["title" => $title, "share" => $share]);

                }
            }

            return redirect(route('servant_services'))->with(['message' => trans('trs.service_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

    public function remove(Service $service)
    {
        try {

            $service->attributes()->delete();
            $service->insurances()->detach();
            $service->teamMembers()->detach();
            $service->delete();

            return redirect(route('servant_services'))->with(['message' => trans('trs.service_removed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

}
