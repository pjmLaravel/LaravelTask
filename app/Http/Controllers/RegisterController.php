<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{

    // 로그인 페이지 이동
    public function showLoginForm() {
        return view('login-form');
    }

    // 로그인

    public function login(Request $request) {
        $email = $request->email;
        $password = $request->password;
    
        $credentials = ['email' => $email, 'password' => $password];
    
        if (!auth()->attempt($credentials)) {
            // return "로그인 정보가 정확하지 않습니다.";
            return redirect()->back()->with('error', '로그인 정보가 정확하지 않습니다.');
        }
    
        // 로그인 성공한 경우 
        return redirect()->route('post.getallpost');
    }
    // public function login(Request $request){
    //     $email = $request -> email;
    //     $password = $request -> password;
    //     $credentials = ['email'=>$email,'password'=>$password];
        
    //     if(! auth()->attempt($credentials)){
    //     return "로그인정보가 정확하지 않습니다.";
    //     dd(auth()->user());
    //     }
    //     return view('posts');
    //     }

    // 회원가입 페이지 이동
    public function showRegisterForm() 
    
    {
        return view('register');
    }

    // 회원가입 

    
public function register(Request $request){
    // 데이터 유효성 검사
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|string|min:4',
    ]);

    // 유효성 검사 실패 시
    if ($validator->fails()) {
        return redirect()->route('login.registerForm')
                        ->withErrors($validator)
                        ->withInput();
    }

    // 유효성 검사 통과 시 사용자 생성
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password)
    ]);

    return redirect('login-email');
}

    // public function register(Request $request){
    //     $name = $request->name;
    //     $email = $request->email;
    //     $password = $request->password;
    //     if(sizeof(User::where('email',$email)->get())<1) {
    //     User::create([
    //     'name' => $name,
    //     'email' => $email,
    //     'password' => bcrypt($password) ]);
    //     return redirect('login-email');
    //     }else{
    //     return redirect()->route('login.registerForm')->with('error', '이미 등록된 email입니다');
    //     }
    //     }




}

