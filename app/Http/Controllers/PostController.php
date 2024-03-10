<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use App\Model\Post;

class PostController extends Controller

{
    // 글 목록
    public function getAllPost()
    {
        $loggedInUserId = auth()->id();

        $posts = DB::table('post')
        ->join('users', 'post.user_id', '=', 'users.id')
        ->select('users.name','user_id','post.id', 'post.subject', 'post.content','post.created_at')
        ->orderBy('post.created_at', 'desc')
        ->paginate(7);
        
        return view('posts', compact('posts', 'loggedInUserId'));
    }

    // 댓글 목록
    public function show(){
        $parentID = $post -> id;
        $comment = DB::table('comments')->where('parent_id', '=', $parentID)->get();
        return view('single-post', compact(['post','comments']));
    }

    // 글 추가
    public function addPost() {
    
        return view('add-post'); 
    }

    // 글 추가 form
    public function addPostSubmit(Request $request) 
    {
        $user_id = auth()->user()->id;

        DB::table('post')->insert([
        'subject' => $request->subject,
        'content' => $request->content,
        'user_id' => $user_id,
        ]);
        return back()->with('post_create', '글이 성공적으로 등록되었습니다.');
    }

        // 개별 글 보기
    public function getPostById($id) 
    {
      
        $post = DB::table('post')
                ->select('users.name', 'post.id', 'post.subject', 'post.content')
                ->join('users', 'post.user_id', '=', 'users.id')
                ->where('post.id', $id)
                ->first(); 

         $parentID = $post -> id;
                $comment = DB::table('comments')->where('parent_id', '=', $parentID)->get();
                // return view('single-post', compact(['post','comment'])
         return view('single-post', compact('post','comment'));
        
    }

    //  글 수정 form

    public function editPost($id)
    {
        $postAuthorId = DB::table('post')->where('id', $id)->value('user_id');
        $loggedInUserId = auth()->user()->id;

         if ($postAuthorId === $loggedInUserId) {
        $post = DB::table('post')->where('id', $id)->first();
        return view('edit-post', compact('post'));
    } else {
        // 작성자가 아닌 경우 다른 처리 또는 리디렉션을 수행
        return redirect()->route('post.getallpost')->with('error', '작성자만 수정할 수 있습니다.');
    }
    }

    // 수정 처리

    public function updatePost(Request $request, $id)
    {


        $loggedInUserId = auth()->user()->id;

        // 글의 작성자 ID 가져오기
        $postAuthorId = DB::table('post')->where('id', $id)->value('user_id');
    
        // 현재 사용자가 글 작성자일 경우에만 수정 로직을 실행
        if ($postAuthorId === $loggedInUserId) {
            DB::table('post')->where('id', $id)->update([
                'subject' => $request->subject,
                'content' => $request->content,
            ]);
    
            return redirect()->route('post.edit', ['id' => $id])
                ->with('post_create', '글이 성공적으로 수정되었습니다.');
        }
            
        
    }



    public function deletePost($id)
    {
        $loggedInUserId = auth()->user()->id;
        $postDeleteId = DB::table('post')->where('id', $id)->value('user_id');
        DB::table('post')->where('id', $id)->delete();

        if ($postDeleteId === $loggedInUserId) {
            DB::table('post')->where('id', $id)->delete();

            return redirect()->route('post.getallpost')
            ->with('post_delete', '글이 성공적으로 삭제되었습니다.');
    } 
    
    }
}










