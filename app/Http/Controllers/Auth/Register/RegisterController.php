<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;

// フォームリクエストの読み込み
use Illuminate\Http\Request;
// バリデーションのファイルの読み込み
use App\Http\Requests\registerUserRequest;
// トランザクションを張る
use Illuminate\Support\Facades\DB;
// 使用するモデルのパス
use App\Models\Users\User;


class RegisterController extends Controller
{
    //ユーザー登録画面の表示
    public function showRegistrationForm()
    {
        return view('auth.register');
        // viewファイル名 指定したファイルをレンダリングする
        // authフォルダの中のregisterファイルを指定
    }

    // ユーザー登録処理
    // バリデーションをかませる
    // ※バリデーションルールのファイルは「App\Http\Requests\registerUserRequest;」
    public function registerUser(registerUserRequest $request)
    {
        DB::beginTransaction();
        try{
            // 登録
                $user_get = User::create([
                    'username' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password)
                ]);

                // 認証メール送信
                
                // commitメソッドでデータベースに反映
                DB::commit();
                return view('loginView');
            }catch(\Exception $e){
                // これまでのデータベースの変更をトランザクションの開始時まで戻す
                // トランザクション
                DB::rollback();
                return redirect()->route('loginform');
            }
    }

}
