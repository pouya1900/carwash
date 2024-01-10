<?php

namespace App\Http\Middleware\Api;

use App\Traits\ResponseUtilsTrait;
use Closure;
use Tymon\JWTAuth\JWT;

class JwtAuthenticate
{
    use ResponseUtilsTrait;

    protected $user;

    public function __construct()
    {
    }

    public function handle($request, Closure $next)
    {
        try {

            if (empty($token = $request->header('Authorization'))) {
                return $this->sendError(trans('messages.auth.apiTokenRequired'));
            }


            if (empty($user = auth("user")->user())) {
                return $this->sendError(trans('messages.auth.apiTokenInvalid'));
            }
            $request->user = $user;

        } catch (\Exception $e) {
            return $this->sendError(trans('messages.auth.apiTokenInvalid'));
        }

        return $next($request);
    }
}
