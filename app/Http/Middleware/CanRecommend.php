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
                'error' => 'Thông báo',
                'message' => 'Bạn chưa tham gia khóa học nào của hệ thống. Hãy thực hiện'
                            .'<a href="'.route('survey.show').'"> khảo sát</a>'
                            .' để nhận được gợi ý từ hệ thống'
            ]));

        return $next($request);
    }
}
