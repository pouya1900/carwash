<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\UpdateUserRequest;
use App\Models\User;
use App\Traits\UploadUtilsTrait;

class UserController extends Controller
{
    use UploadUtilsTrait;

    public function index()
    {
        $admin = $this->request->admin;

        $users = User::orderBy("created_at", "desc")->get();

        return view('admin.users.index', compact('admin', 'users'));
    }

    public function edit(User $user)
    {
        $admin = $this->request->admin;

        return view('admin.users.edit', compact('user', 'admin'));

    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {

            $user->update([
                'email'      => $request->input('email') ?? "",
                'first_name' => $request->input('first_name'),
                'last_name'  => $request->input('last_name'),
                'mobile'     => $request->input('mobile'),
                'balance'    => $request->input('balance'),
                'status'     => $request->input('status'),
            ]);

            if ($this->request->input('deleted_image_avatar')) {
                $this->mediaRemove($user->avatar['model'], 'assetsStorage');
            }

            if ($this->request->hasFile('avatar')) {
                $avatar = $this->request->file('avatar');

                $this->imageUpload($avatar, 'avatar', 'assetsStorage', $user);
            }

            return redirect(route('admin.users'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

}
