<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    // 로그인 이동
    public function showAdminLogin() {
        return view('admin-login');
    }


    // 로그인 폼
    public function adminLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $credentials = compact('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        } else {
            return back();
        }
    }

    // 관리자 글 목록
    public function adminDashboard(Request $request)
    {

        $search = $request->input('search');

        $posts = DB::table('post')
        ->join('users', 'post.user_id', '=', 'users.id')
        ->select('users.name','user_id','post.id', 'post.subject', 'post.content','post.created_at')
        ->orderBy('post.created_at', 'desc')
        ->when($search, function($query, $search) {
                $query->where('subject', 'like', "%$search%");
        })
        ->paginate(7);
        return view('admin-dashboard', compact('posts'));
    }


     //  (관리자) 글 삭제

     public function AdmindeletePost($id)
     {
        //  $postDeleteId = DB::table('post')->where('id', $id)->value('user_id');
        //  DB::table('post')->where('id', $id)->delete();

             DB::table('post')->where('id', $id)->delete();

             return redirect()->route('admin.dashboard')
             ->with('post_delete', '글이 성공적으로 삭제되었습니다.');


     }

     //  관리자 로그아웃
  public function Adminlogout()
  {
    Auth::guard('admin')->logout();

      return redirect('/posts');
  }

    }




