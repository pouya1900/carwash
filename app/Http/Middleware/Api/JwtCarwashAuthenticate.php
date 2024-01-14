<?php

namespace App\Http\Middleware\Api;

use App\Traits\ResponseUtilsTrait;
use Closure;
use Tymon\JWTAuth\JWT;

class JwtCarwashAuthenticate
{
    use ResponseUtilsTrait;

    protected $carwash;

    public function __construct()
    {
    }

    public function handle($request, Closure $next)
    {
        try {

            if (empty($token = $request->header('Authorization'))) {
                return $this->sendError(trans('messages.auth.apiTokenRequired'));
            }


            if (empty($carwash = auth("carwash")->user())) {
                return $this->sendError(trans('messages.auth.apiTokenInvalid'));
            }
            $request->carwash = $carwash;

        } catch (\Exception $e) {
            return $this->sendError(trans('messages.auth.apiTokenInvalid'));
        }

        return $next($request);
    }
}
