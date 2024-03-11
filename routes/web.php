<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisterController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class,'getAllPost'])->name('post.getallpost');

Route::get('/add-post', [PostController::class,'addPost'])->name('post.add')->middleware('auth.check');
Route::post('/add-submit', [PostController::class,'addPostSubmit'])->name('post.addSubmit');


Route::get('/posts/{id}',  [PostController::class,'getPostById'])->name('post.getbyid');

// 개별 글 보기
Route::get('/posts/{id}',  [PostController::class,'getPostById'])->name('post.getbyid');

// 글 수정
Route::get('/edit-post/{id}',  [PostController::class,'editPost'])->name('post.edit');    
Route::post('/update-post/{id}', [PostController::class, 'updatePost'])->name('post.update');

// 글 삭제

Route::get('/delete-post/{id}', [PostController::class, 'deletePost'])->name('post.delete');


// 카카오 로그dls
Route::get('/login/kakao',[LoginController::class, 'redirectToKakao'])->name('login.kakao');
Route::get('/login/kakao/callback', [LoginController::class, 'handleKakaoCallback']);

// 로그아웃

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 댓글 추가
Route::post('/comments/store', [CommentController::class, 'store'])->name('comment.add');


// 로그인 페이지

Route::get('/email', [RegisterController::class,'ShowLoginForm']);

// 회원가입 페이지

Route::get('/register', [RegisterController::class, 'showRegisterForm']);

Route::get('/amu' , [amuController::class, 'amu']);
