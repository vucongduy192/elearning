<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CanRecommend
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
        $student = Auth::user()->student;
        if ($student && count($student->enrolled) == 0 && count($student->survey) == 0)
            return redirect(route('errors', [
                'error' => 'Enroll history error',
                'message' => 'You don\'t have any enrollment history data. Make '
                            .'<a href="'.route('survey.show').'">survey</a>'
                            .' now.'
            ]));

        return $next($request);
    }
}
