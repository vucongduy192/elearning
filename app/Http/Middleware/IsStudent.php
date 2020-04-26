<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role_id != User::STUDENT) {
            return redirect(route('errors', [
                'error' => 'Role type error',
                'message' => 'Login with student account to proceed'
            ]));
        }
        return $next($request);
    }
}
