<?php

namespace App\Http\Controllers;

// use App\Board;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    // 댓글 작성
    public function store(){

        $validator = Validator::make(request()->all(), [
            'parent_id' => 'required',
            'commentStory' => 'required|max:255'
        ]);
        if($validator->fails()){
            return redirect()->back();
        } else {
            Comment::create([
                'parent_id' => request() -> parent_id,
                'userID' => auth() -> id(),
                'userName' => Auth::user()->name,
                'commentStory' => request() -> commentStory
            ]);
            return redirect()->back();
        }
    }

    // 대댓글
    public function replystore(Request $request){

        $validator = Validator::make($request->all(), [
            'topcomment_id' => 'required', // 상위 댓글의 id (topcomment_id)
            'commentStory' => 'required|max:255',
            'parent_id' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back();
        } else{
            Comment::create([
                'topcomment_id' => $request->topcomment_id, // 상위 댓글의 id를 topcomment_id로 저장
                'parent_id' => $request->parent_id,
                'userID' => auth()->id(),
                'userName' => Auth::user()->name,
                'commentStory' => $request->commentStory,

            ]);
            return redirect()->back();
        }
    }

    // 댓글 수정


    public function update(Request $request, $id)
    {

        $comments = Comment::find($id);

        $commentAuthorId = DB::table('comments')->where('id', $id)->value('userID');

            DB::table('comments')->where('id', $id)->update([
                'commentStory' => $request->commentStory
            ]);

            return redirect()->back()->with('success', '댓글이 수정되었습니다.');
    }

    // 댓글 삭제

    public function delete($id) {

        // $commentdelete = DB::table('comments')->where('id', $id)->value('userID');
        DB::table('comments')->where('id', $id)->delete();
        DB::table('comments')->where('topcomment_id', $id)->delete();
            return redirect()->back()->with('delete', '댓글이 삭제되었습니다.');
    }

    }








