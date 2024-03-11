<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{

    // 로그인 페이지
    public function showLoginForm() {
        return view('login-form');
    }

    public function showRegisterForm() 
    
    {
        return view('register');
    }
    

    
}

