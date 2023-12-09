<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// 使用するモデル
use App\Models\Posts\Post;
use App\Models\Posts\PostMainCategory;

use App\Models\Posts\PostSubCategory;
use App\Models\Posts\PostFavorite;



class TopController extends Controller
{
        // 掲示板表示
        public function top(Request $request){
            $posts = Post::with('user', 'postComments')->get();
            $categories = PostMainCategory::get();
            $like = new PostFavorite;
            $post_comment = new Post;
            if(!empty($request->keyword)){
                // 検索ワード タイトル、投稿内容あいまい検索
                $sub_category = $request->keyword;
                $posts = Post::with('user', 'postComments','subCategories')
                ->where('post_title', 'like', '%'.$request->keyword.'%')
                ->orWhere('post', 'like', '%'.$request->keyword.'%')
                ->orwhereHas('subCategories',function($q)use($sub_category){
                    $q->where('sub_category', '=', $sub_category);
                    } )->get();
    
            }else if($request->category_word){
                // 検索ワード サブカテゴリ完全一致
                $sub_category = $request->category_word;
                // echo ddd($sub_category);
                // リレーションを定義した3つのクラスとともにポストテーブルを呼び出す
                // リレーションの情報はビューで必要
                $posts = Post::with('user', 'postComments','subCategories')
                ->whereHas('subCategories',function($q)use($sub_category){
                $q->where('sub_category', '=', $sub_category);
                } )->get();
    
            }else if($request->like_posts){
                // 認証中のユーザがいいねした投稿のIDを取得
                $likes = Auth::user()->likePostId()->get('like_post_id');
                // リレーションを定義した二つのクラスとともにポストテーブルを呼び出す
                $posts = Post::with('user', 'postComments')
                // ポストテーブルの中から認証中のユーザがいいねした投稿のIDに合致するものを取得
                ->whereIn('id', $likes)->get();
            }else if($request->my_posts){
                // 自分の投稿
                $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
            }
            return view('authenticated.top', compact('posts', 'categories', 'like', 'post_comment'));
        }
    //掲示板投稿一覧画面表示
    // 投稿内容をPostから取得
    // public function top(){
    //     return view('authenticated.top');
    //         // viewファイル名 指定したファイルをレンダリングする
    //         // authenticatedフォルダの中のtopファイルを指定
    // }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    
}
