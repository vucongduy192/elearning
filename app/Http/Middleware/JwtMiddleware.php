<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtMiddleware
{
    protected $jwtAuth;

    public function  __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd($request);
        try {
            $user = $this->jwtAuth->parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['errors' => ['message' => trans('auth.jwt_token.invalid')]], 400);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json(['errors' => ['message' => trans('auth.jwt_token.expired')]], 400);
            } else {
                return response()->json(['errors' => ['message' => trans('auth.jwt_token.empty')]], 400);
            }
        }
        return $next($request);
    }
}
