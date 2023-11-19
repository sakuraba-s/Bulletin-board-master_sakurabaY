<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterConfirmController extends Controller
{
    public function RegisterConfirm(Request $request)
    {

        // 入力したメールあてに確認URLを送信する
        // $dataArray  = $request -> only('email');
        $dataArray = $request->all();
        # リクエストの中身 件名：$title メールアドレス:$email 内容：$body

        // メールを送るためには、Mailファサードのsendメソッドを使います。
        // （※メールの文章自体はBladeで作成）
        Mail::send(array('text' => 'email.message'), $dataArray , function($message) use ($dataArray){
            $message->to($dataArray["email"])->subject($dataArray["title"]);
          });


    //登録内容の確認画面を表示させる
        return view('auth.verify');
        // viewファイル名 指定したファイルをレンダリングする
        // authフォルダの中のverifyファイルを指定
    }
}
