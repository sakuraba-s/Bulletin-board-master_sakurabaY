<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'post_sub_category_id',
        'delete_user_id',
        'update_user_id',
        'title',
        'post',
        'event_at',
    ];

    // 投稿内容 ＿ユーザの関係
    // 一つの投稿は一人の投稿者に属する
    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }
    // 投稿内容＿コメントの関係※一対多
    // 一つの投稿は多数のコメントを持ちうる
    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    // ★中間テーブル
    // 投稿内容＿サブカテゴリの関係
    // 多対多
    public function subCategories(){
        // リレーションの定義
        // 投稿とサブカテゴリ―との中間テーブル
        // 投稿＿サブカテゴリ
        return $this->belongsToMany('App\Models\Posts\SubCategory', 'post_sub_categories','post_id','sub_category_id')->withPivot('id');
    }

    // 投稿＿いいねの関係
    // 一つの投稿は多数のいいねを持ちうる
    public function likes()
    {
        return $this->hasMany(Favorite::class,'post_id');
    }

    // コメント数カウント
    // post_commentテーブルのidの数を数える
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }

}
