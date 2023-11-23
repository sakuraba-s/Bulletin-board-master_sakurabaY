<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\registerUsersRequest;


class RegisterController extends Controller
{
    //ユーザー登録画面の表示
    public function showRegistrationForm()
    {
        return view('auth.register');
        // viewファイル名 指定したファイルをレンダリングする
        // authフォルダの中のregisterファイルを指定
    }

    // バリデーションを記述

    // ユーザー登録処理
    // ユーザ新規登録
    // バリデーションをかませる
    // バリデーションルールのファイルは「App\Http\Requests\registerUsersRequest;」(※useでルートを記述しよう)
    public function registerUsers(registerUsersRequest $request)
    {
        DB::beginTransaction();
        try{

            // 登録
                $user_get = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password)
                ]);

                // commitメソッドでデータベースに反映
                // トランザクション
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
