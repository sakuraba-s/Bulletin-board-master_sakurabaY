<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// 使用するモデル
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Posts\MainCategory;
use App\Models\Posts\SubCategory;
use App\Models\Users\User;
// ↓これが投稿のバリデーション
use App\Http\Requests\PostFormRequest;
use Auth;

class TopController extends Controller
{
        // 掲示板トップ画面表示
        public function top(Request $request){
            $posts = Post::with('user', 'postComments')->get();
             // with()でリレーション先のデータを一緒に取得する
             //posts変数にはpostテーブルとそれにリレーションされているuser情報が入っている状態
             // userはモデルのファイルに記述したリレーションのファンクション名(併記可能)
            //  下に記述する条件検索が必要ない場合、ここで取得した投稿が一覧表示される

            // ddd($posts);
            $categories = MainCategory::get();
            // メインカテゴリーテーブルの中身を取得
            // 「カテゴリ検索」のカテゴリ一覧にカテゴリの中身を表示させるため
            $like = new Like;
            // (;'∀')
            // インスタンス化　なぜメインカテゴリのモデルはニューしなくていいの？そもそもインスタンス化とは？？
            $post_comment = new Post;
            // (;'∀')

            // 検索に入力があるとき
            // タイトル…あいまい検索／サブカテゴリー…完全一致／投稿内容…あいまい検索

            if(!empty($request->keyword)){
                // 空ではない
                    // 検索ワード タイトル、投稿内容あいまい検索
                    // いずれかヒットしたものを取得する
                    $sub_category = $request->keyword;
                    // サブカテゴリの完全一致の検索のためにこれだけ変数を用意しておく
                    $posts = Post::with('user','postComments','subCategory')
                        // リレーションを定義した3つのメソッドとともにポストテーブルを呼び出す
                        // ユーザ情報、コメント数カウント、サブカテゴリ　　いいね数？？(;'∀')
                        //以下でそれらを任意の条件で絞り込む
                        ->where('title', 'like', '%'.$request->keyword.'%')
                        //  投稿のタイトルが入力されたキーワードにあいまい検索で一致する場合
                        ->orWhere('post', 'like', '%'.$request->keyword.'%')
                        // または投稿内容が入力されたキーワードに完全一致する場合
                        ->orwhereHas('subCategory',function($q)use($sub_category){
                            $q->where('sub_category', '=', $sub_category);
                            } ) ->get();
                        // またはサブカテゴリが入力されたキーワードに完全一致する場合
                        // Hasはあるモデルからリレーション先のテーブルに対してレコードを探してくれるメソッド

                // または一覧表示されたカテゴリから絞る
            }else if($request->category_word){
                // クリックしたカテゴリー情報を取得
                // 検索ワード サブカテゴリ完全一致
                $sub_category = $request->category_word;
                // echo ddd($sub_category);
                $posts = Post::with('user', 'postComments','subCategory')
                // リレーションを定義した3つのメソッドとともにポストテーブルを呼び出す
                ->whereHas('subCategory',function($q)use($sub_category){
                $q->where('sub_category', '=', $sub_category);
                } )->get();
                // サブカテゴリが入力されたキーワードに完全一致する場合


            // またはいいねしたものをソート
            }else if($request->like_posts){
                // 「いいねした投稿」をクリックしたという情報を取得
                $likes = Auth::user()->likePostId()->get('post_id');
                // リレーションを介して認証中のユーザがいいねした「投稿のID」を取得
                $posts = Post::with('user')
                // リレーションを定義した3つのメソッドとともにポストテーブルを呼び出す
                ->whereIn('id', $likes)->get();
                // ポストテーブルの中から認証中のユーザがいいねした投稿のIDに合致するものを取得

            // または自分の投稿のみをソート
            }else if($request->my_posts){
                // 「自分の投稿」をクリックしたという情報を取得
                $posts = Post::with('user', 'postComments','subCategory')
                // リレーションを定義した3つのメソッドとともにポストテーブルを呼び出す
                ->where('user_id', Auth::id()) ->get();
                // 投稿者のユーザIDがログイン中のユーザIDに一致するものを取得
            }
            // ddd($posts);
            // 結果をビュー側に渡す
            // ddd($posts->subCategory );
            return view('authenticated.top.top', compact('posts', 'categories', 'like', 'post_comment'));
            //posts変数→冒頭で取得したポストテーブルのデータ、または絞り込みで絞られた投稿のデータ
            // categories変数→冒頭で取得したカテゴリ一覧のデータ（カテゴリ検索」の欄用）
            // like変数→　冒頭でインスタンス化したやつ　(;'∀')
            // post_comment変数→　冒頭でインスタンス化したやつ　(;'∀')
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
