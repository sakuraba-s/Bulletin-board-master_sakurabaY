<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;


class Like extends Model
{
    protected $table = 'post_likes';

    protected $fillable = [
        'user_id',
        'post__id',
    ];

    // 投稿についたいいねをカウントする
    // ライクテーブルの中の「投稿のID」がその投稿のIDに一致する数をカウント
    // 引数はビューからもらう
    public function likeCounts($post_id){
        return $this->where('post_id', $post_id)->get()->count();
    }

    // いいねと投稿の関係
    public function post()
    {
      return $this->belongsTo(Post::class);
    }

    // いねとユーザの関係
    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
