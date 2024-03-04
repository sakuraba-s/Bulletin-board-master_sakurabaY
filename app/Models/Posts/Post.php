<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'sub_category_id',
        'delete_user_id',
        'update_user_id',
        'title',
        'post',
        'event_at',
    ];

    // 投稿内容 ＿ユーザの関係
    // ※一対多
    // 一つの投稿は一人の投稿者に属する
    // 従→主
    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }
    // 投稿内容＿コメントの関係
    // ※一対多
    // 一つの投稿は多数のコメントを持ちうる
    // 主→従
    // コメント数はこのデータをカウントすればOK
    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    // 投稿内容＿サブカテゴリの関係
    // ※一対多
    // 従→主
    // 一つの投稿はある一つのカテゴリに属する
    public function subCategory(){
        return $this->belongsTo('App\Models\Posts\SubCategory');
    }

    // その投稿にいいねがどのくらいついているか？
    // 投稿＿いいねの関係
    // usersテーブルとともに中間テーブルを構成する
    // 一つの投稿は多数のいいねを持ちうる
    // favoriteテーブルの投稿のidを取り出す
    // （これをカウントすることで投稿のいいね数をカウントする）
    public function likes()
    {
        return $this->hasMany(Favorite::class,'post_id');
    }

    // 投稿＿コメントに対するいいねの関係
    // post_commentテーブルのidの数を数える
    // public function comment_likes(){
    //     return $this->hasMany(PostCommentFavorite::class,'post_id');
    // }

    // postとコメントに対するいいねのテーブルでは直接の主従関係はない
    // public function comment_likes($post_id){
    //     return Post::with('postComments')->find($post_id)->postComments();
    // }

}
