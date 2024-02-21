<?php

namespace App\Http\Controllers\Admin\Post;

// バリデーションのファイルの読み込み
use App\Http\Requests\PostFormRequest;
// 使用するモデルのパス
use App\Models\Posts\Post;
use App\Models\Posts\MainCategory;
// フォームリクエストの読み込み
use Illuminate\Http\Request;

use Auth;

use App\Http\Controllers\Controller;


class PostsController extends Controller
{
    // 投稿画面の表示
    public function postInput(){
        // モデルからメインカテゴリを取得
        // メインカテゴリの情報を持ちながら投稿ページに遷移
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    // 新規投稿機能
    // バリデーションをかませる
    public function postCreate(PostFormRequest $request){
        // サブカテゴリの取得
        // ※リクエストの右側はnameでつけた名札
        $post_category_id=$request->post_category_id;
        // 投稿をテーブルに反映
        $post_get = Post::create([
            'post_sub_category_id' => $post_category_id,
            'user_id' => Auth::id(),
            'title' => $request->post_title,
            'post' => $request->post_body,
            // nullが許されていないカラムには必ず値を入れること
        ]);

        // ここがおかしい(;'∀')
        // リレーション
        // 上記で新規登録したポストテーブルのidを取得しつつテーブルを取得
        $post = Post::findOrFail($post_get->id);
        // 投稿とサブカテゴリの紐づけ
        $post->subCategories()->attach($post_category_id);

        return redirect()->route('post.show');
    }
}
