<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;


class PostComment extends Model
{
    protected $table = 'post_comments';

    protected $fillable = [
        'user_id',
        'post_id',
        'delete_user_id',
        'update_user_id',
        'comment',
        'event_at',
        'post_sub_category_id',
    ];

    // コメント＿いいねの関係
    // usersテーブルとともに中間テーブルを構成する
    // 一つのコメントは多数のいいねを持ちうる
    // favoriteテーブルの投稿のidを取り出す
    // （これをカウントすることで投稿のいいね数をカウントする）
    public function comment_likes()
    {
        return $this->hasMany(PostCommentFavorite::class,'post_comment_id');
    }
    // コメントとユーザの関係
    // コメントをしたユーザの「名前」を取得
    public function commentUser($user_id){
        return User::where('id', $user_id)->first();
    }
    // public function commentUser(){
    //     return $this->belongsTo('App\Models\Users\User');

    // }
}
