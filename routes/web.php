<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\NoticeController;

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

Route::get('ckeditor', [CkeditorController::class, 'index']);
Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');

// Route::get('/', function () {
//    return view('welcome');
// });

// 모든 게시글
Route::get('/posts', [PostController::class, 'getAllPost'])->name('post.getallpost');
Route::get('/', [PostController::class, 'getAllPost'])->name('post.getallpost');

Route::get('/', [PostController::class, 'getAllPost'])->name('post.getallpost');
// 게시글 작성
Route::get('/add-post', [PostController::class, 'addPost'])->name('post.add')->middleware('auth.check');
Route::post('/add-submit', [PostController::class, 'addPostSubmit'])->name('post.addSubmit');
// 에디터 이미지 업로드
Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload.image')->middleware('cors');


Route::get('/posts/{id}',  [PostController::class, 'getPostById'])->name('post.getbyid');

// 개별 글 보기
Route::get('/posts/{id}',  [PostController::class, 'getPostById'])->name('post.getbyid');

// 글 수정
Route::get('/edit-post/{id}',  [PostController::class, 'editPost'])->name('post.edit');
Route::post('/update-post/{id}', [PostController::class, 'updatePost'])->name('post.update');

// 글 삭제

Route::delete('/delete-post/{id}', [PostController::class, 'deletePost'])->name('post.delete');


// 카카오 로그dls
Route::get('/login/kakao', [LoginController::class, 'redirectToKakao'])->name('login.kakao');
Route::get('/login/kakao/callback', [LoginController::class, 'handleKakaoCallback']);

// 로그아웃

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 댓글 추가
Route::post('/comments/store', [CommentController::class, 'store'])->name('comment.add');
// 대댓글 추가
Route::post('/comments/replystore', [CommentController::class, 'replystore'])->name('comment.addreply');
// 댓글 수정
Route::post('/comments/update/{id}', [CommentController::class, 'update'])->name('comment.update');
// 댓글 삭제
Route::delete('/comments/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');

// 로그인 페이지

Route::get('/login-email', [RegisterController::class, 'showLoginForm'])->name('login.login');
Route::post('/login', [RegisterController::class, 'login'])->name('login');

// 회원가입 페이지

Route::get('/register-form', [RegisterController::class, 'showRegisterForm'])->name('login.registerForm');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// 이메일 중복검사
Route::post('/emailCheck', [RegisterController::class, 'checkEmail'])->name('email.check');

// 마이페이지

Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');

// 관리자 로그인

Route::get('/admin-login', [AdminController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin-login-form', [AdminController::class, 'adminLogin'])->name('admin.loginForm');

// 관리자 로그아웃

Route::post('/admin-logout', [AdminController::class, 'Adminlogout'])->name('admin.logout');

// 관리자 대시보드 (관리자만 접속 가능)

Route::get('/admin-dashboard', [AdminController::class, 'adminDashboard'])->middleware('admin.access')->name('admin.dashboard');


// 관리자 글 삭제
Route::delete('/admin-delete-post/{id}', [AdminController::class, 'AdmindeletePost'])->name('admin.delete');

// 관리자 공지글 삭제
Route::delete('/admin-delete-notice/{id}', [NoticeController::class, 'deleteNotice'])->name('admin.notice.delete');


// 공지사항 작성 (관리자만 접속 가능)
Route::get('/add-notice', [NoticeController::class, 'addNotice'])->middleware('admin.access')->name('notice.add');
Route::post('/add-notice-form', [NoticeController::class, 'addNoticeSubmit'])->name('notice.addsubmit');

// 메인페이지 공지사항 페이지
Route::get('/notices', [NoticeController::class, 'getAllNotice'])->name('notice');

// 관리자 공지사항 페이지 (관리자만 접속 가능)
Route::get('/admin-notices', [NoticeController::class, 'getNotice'])->name('admin.notice')->middleware('admin.access');

// 개별 공지사항 보기
Route::get('/notices/{id}',  [NoticeController::class, 'getNoticeById'])->name('notice.getbyid');
