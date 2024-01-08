<?php

namespace App\Http\Middleware\Api;

use App\Exceptions\AppException;
use App\Traits\ResponseUtilsTrait;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use App\Models\User;
use Closure;

class JwtAuthenticate
{
    use ResponseUtilsTrait;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle($request, Closure $next)
    {
        try {

            if (empty($token = $request->header('Authorization'))) {
                return $this->sendError(trans('messages.auth.apiTokenRequired'));
            }

            $credentials = JWT::decode($token, config('global.jwt.secretKey'), [config('global.jwt.cryptoMethod')]);


            if (
                empty($user = $this->user->find($credentials->sub))
                || $user->token !== $token
            ) {
                return $this->sendError(trans('messages.auth.apiTokenInvalid'));
            }
            $request->user = $user;

        } catch (ExpiredException $e) {
            return $this->sendError(trans('messages.auth.apiTokenExpired'));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.auth.apiTokenInvalid'));
        }

        return $next($request);
    }
}
