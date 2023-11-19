<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterAddedController extends Controller
{
    //ユーザ登録操作
    //登録機能
    public function Register()
    {
        // 登録に成功すればログイン画面に遷移
        $userdata = $request -> only('email', 'password');
        if (Auth::attempt($userdata)) {
            // Auth::attemptで該当するUserを拾ってくる
            // 認証が成功すればtrueを返す
            // その場合トップページに遷移させる
            return redirect('top');
        }else{
            // dd($userdata);
            return redirect('loginform')->with('flash_message', 'name or password is incorrect');
         // 失敗すればユーザ登録画面を再度表示させる

        }
    }
}
