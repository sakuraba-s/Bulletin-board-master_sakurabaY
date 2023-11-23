<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class RegisterConfirmController extends Controller
{
    public function RegisterConfirm(Request $request)
    {

        // // 入力したメールあてに確認URLを送信する
        // // $dataArray  = $request -> only('email');
        // $dataArray = $request->all();
        // # リクエストの中身 件名：$title メールアドレス:$email 内容：$body

        // // メールを送るためには、Mailファサードのsendメソッドを使います。
        // // （※メールの文章自体はBladeで作成）
        // Mail::send(function($message) use ($dataArray){
        //     $message->to($dataArray["email"]);
        //   });

    }
}
