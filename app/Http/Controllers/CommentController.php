<?php

namespace App\Http\Controllers;

// use App\Board;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(){
        $validator = Validator::make(request()->all(), [
            'parent_id' => 'required',
            'commentStory' => 'required|max:255'
        ]);
        if($validator->fails()){
            return redirect()->back();
        } else{
            Comment::create([
                'parent_id' => request() -> parent_id,
                'userID' => auth() -> id(),
                'userName' => Auth::user()->name,
                'commentStory' => request() -> commentStory
            ]);
            return redirect()->back();
        }
    }

    // public function show(Board $board){
    //     $boards = Board::all()->sortByDesc('id')->take(10);
    //     $parentID = $board -> id;
    //     $comment = DB::table('comments')->where('parent_id', '=', $parentID)->get();
    //     return view('single-post', compact(['board', 'boards', 'comment']));
    // }
}