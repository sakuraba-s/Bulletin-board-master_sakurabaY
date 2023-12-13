<?php

namespace App\Http\Controllers\User\Post;

use App\Models\Posts\PostMainCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    // 新規投稿ぺージを表示
    public function input(){
        return view('authenticated.top.top');
    }

}
