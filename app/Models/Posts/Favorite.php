<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\Favorite;


class Favorite extends Model
{
  // 度の投稿に誰が言いねしたかのセット（いいねテーブル）
    protected $table = 'post_favorites';

    protected $fillable = [
        'user_id',
        'post__id',
    ];

        // いいねをカウントする
    // ライクテーブルの中の「いいねした投稿のID」がその投稿のIDに一致する数をカウント
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
