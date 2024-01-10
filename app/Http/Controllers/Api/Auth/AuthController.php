<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\SendOtpEvent;
use App\Http\Controllers\Controller;
use App\Models\Activation;
use App\Models\Carwash;
use App\Models\User;
use App\Traits\ResponseUtilsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class AuthController extends Controller
{
    use ResponseUtilsTrait;


    public function send_otp()
    {
        $this->validateRequest(
            $this->request->input(), [
                'mobile' => "required|numeric|digits_between:9,25",
            ]
        );

        $mobile = $this->request->input('mobile');
        $code = rand(100000, 999999);

        $activation = Activation::where('mobile', $mobile)->first();

        if ($activation) {

            if ($activation->attempt == 3 && $activation->attempt_at > Carbon::now()->subMinutes(30)) {
                return $this->sendError(trans('messages.auth.otpBlock'));
            }

            if ($activation->created_at > Carbon::now()->subMinutes(2)) {
                return $this->sendError(trans('messages.auth.activationCodeWaitTimeFail', ["time" => 120]));
            }

            $activation->delete();
        }

        $activation = Activation::create([
            'mobile'     => $mobile,
            'code'       => $code,
            'expired_at' => Carbon::now()->addMinutes(2),
        ]);

        Event::dispatch(new SendOtpEvent($mobile, $code));

//        data should delete in last version

        $data = [
            'expiredSeconds' => 120,
            'mobile'         => $mobile,
            'code'           => $code,
        ];

        return $this->sendResponse($data, trans('messages.auth.activationCodeSent'));

    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $this->validateRequest($this->request->input(), [
            'activation_code' => 'required|numeric|digits:6',
            'type'            => 'required|in:user,carwash',
            'mobile'          => "required|numeric|digits_between:9,25|exists:activations,mobile",
            'uuid'            => 'required|string|min:30|max:60',
            'platform'        => 'required|string|in:mobile,web',
            'model'           => 'required|string|min:3|max:50',
            'os'              => 'required|string|min:3|max:50',
        ]);

        $type = $this->request->input('type');

        if ($type == "user") {
            if (auth('carwash')->check()) {
                auth('carwash')->logout();
            }

            if (auth('user')->check()) {
                return $this->sendError(trans('messages.auth.alreadyLoggedIn'));
            }
        } else {
            if (auth('user')->check()) {
                auth('user')->logout();
            }

            if (auth('carwash')->check()) {
                return $this->sendError(trans('messages.auth.alreadyLoggedIn'));
            }
        }


        $mobile = $this->request->input('mobile');
        $code = $this->request->input('activation_code');

        $activation = Activation::where('mobile', $mobile)->first();

        if (!$activation) {
            return $this->sendError(trans('messages.auth.activationCodeInvalid'));
        }

        if ($activation->attempt == 3) {
            return $this->sendError(trans('messages.auth.otpBlock'));
        }

        if ($activation->expired_at < Carbon::now()) {
            return $this->sendError(trans('messages.auth.activationCodeExpired'));

        }

        $activation->update([
            'attempt'    => $activation->attept + 1,
            'attempt_at' => Carbon::now(),
        ]);


        if ($activation->code != $code) {
            return $this->sendError(trans('messages.auth.activationCodeInvalid'));
        }

        if ($type == "user") {
            $instance = new User();
        } else {
            $instance = new Carwash();
        }


        if (!$login = $instance->where('mobile', $mobile)->first()) {
            $login = $instance->create([
                'mobile'   => $mobile,
                'uuid'     => $this->request->input("uuid"),
                'platform' => $this->request->input("platform"),
                'model'    => $this->request->input("model"),
                'os'       => $this->request->input("os"),
            ]);
        } else {
            $login->update([
                'uuid'     => $this->request->input("uuid"),
                'platform' => $this->request->input("platform"),
                'model'    => $this->request->input("model"),
                'os'       => $this->request->input("os"),
            ]);
        }

        $token = auth($type)->login($login);

        return $this->sendResponse([
            "userToken" => $token,
        ]);

    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth("user")->logout();
        auth("carwash")->logout();

        return $this->sendResponse([], trans("messages.auth.logOutSuccess"));
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->sendResponse([
            "userToken" => auth()->refresh(),
        ]);
    }


}
