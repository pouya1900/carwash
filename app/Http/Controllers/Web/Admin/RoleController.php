<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\UpdateRolePermissionRequest;
use App\Models\Administrator;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $admin = $this->request->admin;

        $roles = Role::all();

        foreach ($roles as $role) {

            $permission_text = "";
            $f = 0;
            foreach ($role->permissions as $permission) {
                if ($f) {
                    $permission_text .= ",";
                }
                $permission_text .= $permission->title;
                $f = 1;
            }
            $role->permissions_text = $permission_text;

        }
        return view('admin.roles.index', compact('admin', 'roles'));
    }

    public function create()
    {
        $admin = $this->request->admin;
        $permissions = Permission::all();

        return view('admin.roles.create', compact('admin', 'permissions'));
    }

    public function store(UpdateRolePermissionRequest $request)
    {
        try {
            $permissions = $request->input('permissions');

            if ($request->input('name') == "super") {
                return redirect()->withErrors(['error' => trans('trs.super_permission_cant_change')]);
            }

            $role = Role::create([
                'name'  => $request->input('name'),
                'title' => $request->input('title'),
            ]);

            if ($permissions) {
                foreach ($permissions as $permission) {
                    $role->permissions()->attach($permission);
                }
            }
            return redirect(route('admin.roles'))->with('message', trans('trs.changed_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function edit(Role $role)
    {
        $admin = $this->request->admin;

        $permissions = Permission::all();

        return view('admin.roles.edit', compact('admin', 'role', 'permissions'));
    }

    public function update(UpdateRolePermissionRequest $request, Role $role)
    {
        try {
            $permissions = $request->input('permissions');

            if ($role->name == "super") {
                return redirect()->withErrors(['error' => trans('trs.super_permission_cant_change')]);
            }

            $role->permissions()->detach();
            if ($permissions) {
                foreach ($permissions as $permission) {
                    $role->permissions()->attach($permission);
                }
            }
            return redirect(route('admin.roles'))->with('message', trans('trs.changed_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }


    public function remove(Role $role)
    {
        try {
            $role->delete();
            return redirect(route('admin.roles'))->with('message', trans('trs.changed_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }

    }

}
