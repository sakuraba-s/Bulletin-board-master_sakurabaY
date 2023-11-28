<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;;
use Illuminate\Auth\MustVerifyEmail;

// 認証機能として使う
use Illuminate\Foundation\Auth\User as Authenticatable;

// (;'∀')
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements  MustVerifyEmailContract
{
    use Notifiable, MustVerifyEmail;


    protected $fillable = [
        'username',
        'email',
        'password',
        'admin_role',
        // カラムに値を挿入できるようにする
    ];
}
