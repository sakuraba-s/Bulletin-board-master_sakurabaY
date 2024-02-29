<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;;
use Illuminate\Auth\MustVerifyEmail;
use Auth;
use App\Models\Posts\Favorite;


// 認証機能として使う
use Illuminate\Foundation\Auth\User as Authenticatable;

// (;'∀')
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements  MustVerifyEmailContract
{
    // use Notifiable, MustVerifyEmail;
    protected $fillable = [
        'username',
        'email',
        'password',
        'admin_role',
    ];
    // ユーザー＿投稿内容の関係
    // 一対多
    // 主→従
    // ユーザに対して投稿は複数存在する
    public function posts(){
        return $this->hasMany('App\Models\Posts\Post');
    }

    // →ログイン中ユーザはその投稿をいいねしている？
    // 「いいねした人のID」が認証中のユーザのID かつ
    // 「いいねした投稿のID」がその投稿のIDに一致する
    // ※引数はビューから受け取っている
    public function is_Like($post_id){
        return Like::where('user_id', Auth::id())->where('post_id', $post_id)->first(['likes.id']);
    }

    public function likePostId(){
        // いいねした人のIDが認証中のユーザIDに一致
        return Like::where('user_id', Auth::id());
    }

}
