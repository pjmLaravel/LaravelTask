<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id', 'userID', 'userName', 'commentStory', 'topcomment_id'
      ];


      public function user()
      {
        return $this->belongsTo(User::class);
      }


      public function post()
      {
          return $this->belongsTo(Post::class);
      }

      public function replies()
      {

        return $this->hasMany(Comment::class, 'topcomment_id', 'comment_id');
        // return $this->hasMany(Comment::class, 'parent_id', 'topcomment_id'); 기존 코드
      }
}
