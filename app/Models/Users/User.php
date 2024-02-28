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
        // カラムに値を挿入できるようにする
    ];
    // ユーザー＿投稿内容の関係
    // 一対多
    // ユーザに対して投稿は複数存在する
    // このメソッドを呼び出すことでユーザ情報だけでなく東湖内容のデータも取得できる
    public function posts(){
        return $this->hasMany('App\Models\Posts\Post');
    }

        // →ログイン中ユーザがその投稿をいいねしているかどうか
    // 「いいねした人のID」が認証中のユーザのID かつ
    // 「いいねした投稿のID」がその投稿のIDに一致する
    public function is_Like($post_id){
        return Favorite::where('user_id', Auth::id())->where('post_id', $post_id)->first(['post_favorites.id']);
    }

    public function likePostId(){
        // いいねした人のIDが認証中のユーザIDに一致
        return Favorite::where('user_id', Auth::id());
    }

}
