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
        public function top(Request $request){
            $posts = Post::with('user')->get();
             // with()でリレーション先のデータを一緒に取得する
             //posts変数にはpostテーブルとそれにリレーションされているuser情報が入っている状態
             // userはモデルのファイルに記述したリレーションのファンクション名(併記可能)
            $categories = MainCategory::get();
            // メインカテゴリーテーブルの中身を取得

            $like = new Favorite;
            // インスタンス化　なぜメインカテゴリのモデルはニューしなくていいの？そもそもインスタンス化とは？？
            $post_comment = new Post;

            // 検索に入力があるとき
            // タイトル…あいまい検索／サブカテゴリー…完全一致／投稿内容…あいまい検索

            if(!empty($request->keyword)){
            // 空ではない
                // 検索ワード タイトル、投稿内容あいまい検索
                // いずれかヒットしたものを取得する
                $sub_category = $request->keyword;
                // サブカテゴリの完全一致の検索のためにこれだけ変数を用意しておく
                $posts = Post::with('user', 'post','subCategories')
                ->where('title', 'like', '%'.$request->keyword.'%')
                //  投稿のタイトルが入力されたキーワードにあいまい検索で一致する場合
                ->orWhere('post', 'like', '%'.$request->keyword.'%')
                // または投稿内容が入力されたキーワードに完全一致する場合
                ->orwhereHas('subCategories',function($q)use($sub_category){
                    $q->where('sub_category', '=', $sub_category);
                    } )
                    // またはサブカテゴリが入力されたキーワードに完全一致する場合
                    // Hasはあるモデルからリレーション先のテーブルに対してレコードを探してくれるメソッド
                ->get();

            // または一覧表示されたカテゴリから絞る
            }else if($request->category_word){
                // クリックしたカテゴリー情報を取得
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

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    
}
