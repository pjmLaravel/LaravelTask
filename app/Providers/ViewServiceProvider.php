<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // 여기에 모든 뷰에 전달할 데이터를 추가
            $kakaoUser = Socialite::driver('kakao')->user();
            $view->with('kakaoUser', $kakaoUser);
        });
    }
    }

