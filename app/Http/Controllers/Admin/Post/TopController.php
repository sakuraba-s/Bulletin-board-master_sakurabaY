<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopController extends Controller
{
    //掲示板投稿一覧画面
    public function top(){
        return view('authenticated.top');
            // viewファイル名 指定したファイルをレンダリングする
            // authenticatedフォルダの中のtopファイルを指定
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    
}
