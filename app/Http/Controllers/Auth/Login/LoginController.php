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
        }

        // ログイン機能
        public function Login(Request $request)
        {
            // 認証成功すればトップ画面
            $userdata = $request -> only('email', 'password');
            if (Auth::attempt($userdata)) {
                // Auth::attemptで該当するUserを拾ってくる
                // Authファザード
                // 認証が成功すればtrueを返す
                return redirect('loginform');
            // 失敗すればログイン画面へ
            }else{
                return redirect('loginform')->with('flash_message', 'name or password is incorrect');
            }
        }
    //
}
