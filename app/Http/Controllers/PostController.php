<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post as posts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class PostController extends Controller

{
    // 글 목록
    public function getAllPost(Request $request)
    {
        $loggedInUserId = auth()->id();
        $search = $request->input('search');

        $posts = DB::table('post')
        ->join('users', 'post.user_id', '=', 'users.id')
        ->select('users.name','user_id','post.id', 'post.subject', 'post.content','post.created_at')
        ->orderBy('post.created_at', 'desc')
        ->when($search, function($query, $search) {
                $query->where('subject', 'like', "%$search%");
        })
        ->paginate(7);

        return view('posts', compact('posts', 'loggedInUserId'));
    }

    // 댓글 목록
    public function show(posts $post){
        $parentID = $post -> id;
        $comment = DB::table('comments')->where('parent_id', '=', $parentID)->get();
        return view('single-post', compact(['parentID','comments']));
    }


    // 글 추가
    public function addPost() {

        return view('add-post');
    }

    // 글 추가 form

    public function addPostSubmit(Request $request)
{
    $user_id = auth()->user()->id;
    $createdAt = Carbon::now();
    $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    $imagePath = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $originalName = $image->getClientOriginalName(); // 원본 파일명 가져오기
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $image->getClientOriginalExtension(); // 새로운 파일명 생성
        $image->move(public_path('images'), $imageName);

        // 이미지 경로 설정
        $imagePath = 'images/' . $imageName;
    }


    DB::table('post')->insert([
        'subject' => $request->subject,
        'content' => $request->content,
        'user_id' => $user_id,
        'created_at' => $createdAt,
        'img_path' => $imagePath
    ]);

    return redirect()->route('post.getallpost')
        ->with('post_create', '글이 성공적으로 등록되었습니다.');
}

//     public function addPostSubmit(Request $request)
// {
//     $user_id = auth()->user()->id;
//     $createdAt = now();
//     $request->validate([
//         'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);
//     if ($request->hasFile('image')) {
//     $image = $request->file('image');
//     $originalName = $image->getClientOriginalName(); // 원본 파일명 가져오기
//     $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $image->getClientOriginalExtension(); // 새로운 파일명 생성
//     $image->move(public_path('images'), $imageName);

//     DB::table('post')->insert([
//         'img_path' => 'images/' . $imageName
//     ]);
//    }

//     DB::table('post')->insert([
//         'subject' => $request->subject,
//         'content' => $request->content,
//         'user_id' => $user_id,
//         'created_at' => $createdAt,
//         // 'img_path' => 'images/' . $imageName
//     ]);
//     return redirect()->route('post.getallpost')
//         ->with('post_create', '글이 성공적으로 등록되었습니다.');
// }


            // 개별 글 보기
        public function getPostById($id)
        {

            $post = DB::table('post')
                    ->select('users.name', 'post.id', 'post.subject', 'post.content', 'post.img_path')
                    ->join('users', 'post.user_id', '=', 'users.id')
                    ->where('post.id', $id)
                    ->first();

                    if (!$post) {
                        // 게시물이 존재하지 않는 경우 예외 처리
                        return redirect()->back()->with('error', '게시물을 찾을 수 없습니다.');
                    }

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
        $updatedAt = now();

        // 글의 작성자 ID 가져오기
        $postAuthorId = DB::table('post')->where('id', $id)->value('user_id');

        // 현재 사용자가 글 작성자일 경우에만 수정 로직을 실행
        if ($postAuthorId === $loggedInUserId) {
            DB::table('post')->where('id', $id)->update([
                'subject' => $request->subject,
                'content' => $request->content,
                'updated_at' => $updatedAt,
            ]);

            return redirect()->route('post.edit', ['id' => $id])
                ->with('post_create', '글이 성공적으로 수정되었습니다.');
        }


    }


    //  글 삭제

    public function deletePost($id)
    {
        $loggedInUserId = auth()->user()->id;
        $postDeleteId = DB::table('post')->where('id', $id)->value('user_id');
        // DB::table('post')->where('id', $id)->delete();

        if ($postDeleteId === $loggedInUserId) {
            DB::table('post')->where('id', $id)->delete();

            return redirect()->route('post.getallpost')
            ->with('post_delete', '글이 성공적으로 삭제되었습니다.');
    }

    }


}










