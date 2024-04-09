<?php

namespace App\Http\Controllers\Web;

use App\Events\SendOtpEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\LoginRequest;
use App\Models\Activation;
use App\Models\Administrator;
use App\Models\Carwash;
use App\Models\User;
use App\Traits\UploadUtilsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    use UploadUtilsTrait;

    public function login($type)
    {
        if ($type != "user" && $type != 'carwash' && $type != 'admin') {
            abort(404);
        }

        if (auth::guard('carwash')->check()) {
            if ($type == 'user' || $type == 'admin') {
                auth::guard('carwash')->logout();
            } else {
                return redirect(route('carwash_dashboard'));
            }
        }

        if (auth::guard('web_user')->check()) {
            if ($type == 'carwash' || $type == 'admin') {
                auth::guard('web_user')->logout();
            } else {
                return redirect(route('user_show'));
            }
        }

        if (auth::guard('admin')->check()) {
            if ($type == 'carwash' || $type == 'user') {
                auth::guard('admin')->logout();
            } else {
                return redirect(route('admin.dashboard'));
            }
        }

        return view('front.auth.login', compact('type'));
    }


    public function send_otp()
    {
        $mobile = $this->request->input('mobile');

        $code = rand(100000, 999999);

        $activation = Activation::where('mobile', $mobile)->first();

        if ($activation) {

            if ($activation->attempt == 3 && $activation->attempt_at > Carbon::now()->subMinutes(30)) {
                return response()->json(['status' => 1, 'error' => trans('trs.otp_too_many_attempt')]);
            }

            if ($activation->created_at > Carbon::now()->subMinutes(2)) {
                return response()->json(['status' => 1, 'error' => trans('trs.otp_should_send_in_two_minute')]);
            }

            $activation->delete();
        }

        $activation = Activation::create([
            'mobile'     => $mobile,
            'code'       => $code,
            'expired_at' => Carbon::now()->addMinutes(2),
        ]);

        Event::dispatch(new SendOtpEvent($mobile, $code));

//        code should delete in last version

        return response()->json(['status' => 0, 'message' => trans('trs.otp_sent'), 'code' => $code]);

    }

    public function do_carwash_login(LoginRequest $request)
    {
        $mobile = $request->input('mobile');
        $code = $request->input('code');

        $activation = Activation::where('mobile', $mobile)->first();


        if (!$activation) {
            return response()->json(['status' => 1, 'error' => trans('trs.there_is_an_error')]);
        }

        if ($activation->attempt == 3) {
            return response()->json(['status' => 1, 'error' => trans('trs.otp_too_many_attempt')]);
        }

        if ($activation->expired_at < Carbon::now() || $activation->completed_at) {
            return response()->json(['status' => 1, 'error' => trans('trs.otp_expired')]);
        }


        if ($activation->code != $code) {
            $activation->update([
                'attempt'    => $activation->attept + 1,
                'attempt_at' => Carbon::now(),
            ]);
            return response()->json(['status' => 1, 'error' => trans('trs.otp_not_correct')]);
        }

        $activation->update([
            'completed_at' => Carbon::now(),
        ]);

        if (!$carwash = Carwash::where('mobile', $mobile)->first()) {
            $carwash = Carwash::create([
                'mobile'   => $mobile,
                'city_id'  => 0,
                'state_id' => 0,
            ]);
        }

        auth::guard('carwash')->login($carwash, $request->has('remember'));

        return response()->json(['status' => 0, 'url' => route('carwash_dashboard')]);


    }

    public function do_user_login(LoginRequest $request)

    {
        $mobile = $request->input('mobile');
        $code = $request->input('code');

        $activation = Activation::where('mobile', $mobile)->first();

        if (!$activation) {
            return response()->json(['status' => 1, 'error' => trans('trs.there_is_an_error')]);
        }

        if ($activation->attempt == 3) {
            return response()->json(['status' => 1, 'error' => trans('trs.otp_too_many_attempt')]);
        }

        if ($activation->expired_at < Carbon::now()) {
            return response()->json(['status' => 1, 'error' => trans('trs.otp_expired')]);
        }

        $activation->update([
            'attempt'    => $activation->attept + 1,
            'attempt_at' => Carbon::now(),
        ]);


        if ($activation->code != $code) {
            return response()->json(['status' => 1, 'error' => trans('trs.otp_not_correct')]);
        }

        if (!$user = User::where('mobile', $mobile)->first()) {
            $user = User::create([
                'mobile' => $mobile,
            ]);
        }

        auth::guard('web_user')->login($user, $request->has('remember'));

        return response()->json(['status' => 0, 'url' => route('user_show'), 'user' => $user]);

    }

    public function do_admin_login(LoginRequest $request)

    {
        $mobile = $request->input('mobile');
        $code = $request->input('code');

        $activation = Activation::where('mobile', $mobile)->first();

        if (!$activation) {
            return response()->json(['status' => 1, 'error' => trans('trs.there_is_an_error')]);
        }

        if ($activation->attempt == 3) {
            return response()->json(['status' => 1, 'error' => trans('trs.otp_too_many_attempt')]);
        }

        if ($activation->expired_at < Carbon::now()) {
            return response()->json(['status' => 1, 'error' => trans('trs.otp_expired')]);
        }

        $activation->update([
            'attempt'    => $activation->attept + 1,
            'attempt_at' => Carbon::now(),
        ]);


        if ($activation->code != $code) {
            return response()->json(['status' => 1, 'error' => trans('trs.otp_not_correct')]);
        }

        if (!$admin = Administrator::where('mobile', $mobile)->first()) {
            return response()->json(['status' => 1, 'error' => trans('trs.admin_not_exist')]);
        }

        auth::guard('admin')->login($admin, $request->has('remember'));

        return response()->json(['status' => 0, 'url' => route('admin.dashboard')]);

    }


    public function logout()
    {
        auth::guard('carwash')->logout();
        auth::guard('web_user')->logout();
        auth::guard('admin')->logout();

        return redirect(route('home'));
    }


}
