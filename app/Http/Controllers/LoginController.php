<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToKakao()
    {
        return Socialite::driver('kakao')->redirect();
    }

    public function handleKakaoCallback()
    {
        $socialUser = Socialite::driver('kakao')->user();

        $existUser = User::where('name', $socialUser->name)->first();

        if (!$existUser) {
            // 사용자 생성 로직
            $existUser = User::create([
                'name' => $socialUser->name,
                'password' => '12345'
                // 'email' => $socialUser->email,
                // 기타 필요한 정보 추가
            ]);
        }

        auth()->login($existUser);

        return redirect('/posts');
    }

    //   로그아웃
    public function logout()
    {
        Auth::logout();

        return redirect('/posts');
    }
}
