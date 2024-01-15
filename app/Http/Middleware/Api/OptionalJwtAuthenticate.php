<?php

namespace App\Http\Middleware\Api;

use App\Models\User;
use App\Traits\ResponseUtilsTrait;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class OptionalJwtAuthenticate
{
    use ResponseUtilsTrait;

    protected $user;

    public function __construct()
    {
    }

    public function handle($request, Closure $next)
    {
        try {


            if (!empty($user = auth("user")->user())) {
                $request->user = $user;
            }

        } catch (\Exception $e) {
            return $this->sendError(trans('messages.auth.apiTokenInvalid'));
        }

        return $next($request);
    }
}
