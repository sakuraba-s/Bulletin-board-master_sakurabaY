<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class PostCommentFavorite extends Model
{
    protected $table = 'post_comment_likes';

    protected $fillable = [
        'user_id',
        'post_comment_id',
    ];
}
