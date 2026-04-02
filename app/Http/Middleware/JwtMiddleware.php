<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\ApiReturnFormatTrait;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    use ApiReturnFormatTrait;

    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->responseWithError(__('invalid_token'), [], 401);
            } elseif ($e instanceof TokenExpiredException) {
                return $this->responseWithError(__('Token is expired'), [], 401);
            } else {
                return $this->responseWithError(__('Authorization token not found'), [], 401);
            }
        }
        if ($user) {
            return $next($request);
        } else {
            return $this->responseWithError(__('invalid_token'), [], 401);
        }
    }
}
