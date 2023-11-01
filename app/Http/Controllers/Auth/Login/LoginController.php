<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
        // ログイン画面
        public function showLoginForm()
        {
            return view('auth.login');
            // viewファイル名 指定したファイルをレンダリングする
            // authフォルダの中のloginファイルを指定
        }

        // ログイン機能
        public function Login(Request $request)
        {
        // 認証成功すればトップ画面
        $userdata = $request -> only('email', 'password');
        if (Auth::attempt($userdata)) {
            // Auth::attemptで該当するUserを拾ってくる
            // 認証が成功すればtrueを返す
            // その場合トップページに遷移させる
            return redirect('top');
        }else{
            return redirect('top')->with('flash_message', 'name or password is incorrect');
         // 失敗すればログイン画面へ遷移させる

        }
        }
    //
}
