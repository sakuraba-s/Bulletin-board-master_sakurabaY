<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// 使用するモデル
use App\Models\Posts\Post;
use App\Models\Posts\MainCategory;
use App\Models\Posts\SubCategory;
use App\Models\Posts\Favorite;
use App\Models\Users\User;
// ↓これが投稿のバリデーション
use App\Http\Requests\PostFormRequest;

use Auth;


class TopController extends Controller
{
        // 掲示板トップ画面表示
        // with()でリレーション先のデータを一緒に取得する
        // userはモデルのファイルに記述したリレーションのファンクション名(併記可能)
        public function top(Request $request){
            $posts = Post::with('user')->get();
            

            $categories = MainCategory::get();
            $like = new Favorite;
            $post_comment = new Post;


            // 検索に入力があるとき
            if(!empty($request->keyword)){
                // 検索ワード タイトル、投稿内容あいまい検索
                $sub_category = $request->keyword;
                $posts = Post::with('user', 'post','subCategories')
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

            // いいねしたものをソート
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


            // 変数をビュー側に渡す
            return view('authenticated.top.top', compact('posts', 'categories', 'like', 'post_comment'));
        }


        // 詳細画面
        public function postDetail($post_id){
            $post = Post::with('user', 'postComments')->findOrFail($post_id);
            return view('authenticated.bulletinboard.post_detail', compact('post'));
        }

    // 投稿画面の表示
    public function postInput(){
        // モデルからメインカテゴリを取得
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    // 新規投稿機能
    // バリデーションをかませる
    public function postCreate(PostFormRequest $request){
        // サブカテゴリの取得
        $post_category_id=$request->post_category_id;
        // 投稿をテーブルに反映
        $post_get = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        // リレーション
        // 上記で新規登録したポストテーブルのidを取得しつつテーブルを取得
        $post = Post::findOrFail($post_get->id);
        // 投稿とサブカテゴリの紐づけ
        $post->subCategories()->attach($post_category_id);

        return redirect()->route('post.show');
    }
    
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    
}
