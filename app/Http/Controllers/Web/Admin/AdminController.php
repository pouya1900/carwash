<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\StoreAdminRequest;
use App\Http\Requests\Web\Admin\UpdateAdminRequest;
use App\Models\Administrator;
use App\Models\Role;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use UploadUtilsTrait;

    public function index()
    {
        $admin = $this->request->admin;

        $administrators = Administrator::all();

        return view('admin.admins.index', compact('admin', 'administrators'));
    }

    public function create()
    {
        $admin = $this->request->admin;
        $roles = Role::all();

        return view('admin.admins.create', compact('roles', 'admin'));
    }

    public function store(StoreAdminRequest $request)
    {
        try {

            $administrator = Administrator::create([
                'first_name' => $request->input('first_name'),
                'last_name'  => $request->input('last_name'),
                'mobile'     => $request->input('mobile'),
                'role_id'    => $request->input('role'),
            ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $this->imageUpload($avatar, 'avatar', 'assetsStorage', $administrator);
            }

            return redirect(route('admin.admins'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function edit(Administrator $administrator)
    {
        $admin = $this->request->admin;

        $roles = Role::all();

        return view('admin.admins.edit', compact('roles', 'administrator', 'admin'));

    }

    public function update(UpdateAdminRequest $request, Administrator $administrator)
    {
        try {
            DB::beginTransaction();

            $administrator->update([
                'first_name' => $request->input('first_name'),
                'last_name'  => $request->input('last_name'),
                'mobile'     => $request->input('mobile'),
                'role_id'    => $request->input('role'),
            ]);

            if (!Administrator::whereHas('role', function ($q) {
                return $q->where('name', 'super');
            })->first()) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => trans('trs.cant_remove_super_role')]);
            }
            DB::commit();

            if ($request->input('deleted_image_avatar')) {
                $avatar = $administrator->avatar["model"];
                if ($avatar) {
                    $this->mediaRemove($avatar, 'assetsStorage');
                }
            }
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $this->imageUpload($avatar, 'avatar', 'assetsStorage', $administrator);
            }

            return redirect(route('admin.admins'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }


    public function remove(Administrator $administrator)
    {
        try {
            DB::beginTransaction();

            $administrator->delete();

            if (!Administrator::whereHas('role', function ($q) {
                return $q->where('name', 'super');
            })->first()) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => trans('trs.cant_remove_super_role')]);
            }
            DB::commit();

            return redirect(route('admin.admins'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }
}
