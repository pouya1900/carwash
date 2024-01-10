<?php

namespace App\Http\Middleware\Api;

use App\Traits\ResponseUtilsTrait;
use Closure;

class AppSecretMiddleware
{
    use ResponseUtilsTrait;

    public function handle($request, Closure $next, $guard = null)
    {

        if (
            empty($secretKey = $request->header('secret-key'))) {
            return $this->sendError(trans('messages.auth.appSecretRequiredMessage'));
        }

        if ($secretKey !== env('APP_SECRET_KEY')) {
            return $this->sendError(trans('messages.auth.appSecretFailMessage'));
        }

        return $next($request);
    }
}
