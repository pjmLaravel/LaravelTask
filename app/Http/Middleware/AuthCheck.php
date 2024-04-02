<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    public function handle($request, Closure $next)
    {
        // 인증된 사용자인지 확인
        if (Auth::check()) {
            return $next($request);
        }

        // 로그인되어 있지 않으면 로그인 페이지로 리다이렉트
        return redirect('/login-email');
    }
}

