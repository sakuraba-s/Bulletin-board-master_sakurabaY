<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //登録したあと？画面の表示
    public function showRegistrationForm()
    {
        return view('auth.register');
        // viewファイル名 指定したファイルをレンダリングする
        // authフォルダの中のregisterファイルを指定
    }

    // バリデーションを記述
}
