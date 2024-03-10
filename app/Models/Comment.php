<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'parent_id', 'userID', 'userName', 'commentStory'
      ];

      public function post()
      {
          return $this->belongsTo(Post::class, 'parent_id');
      }
}
