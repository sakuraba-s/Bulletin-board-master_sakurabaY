<?php

namespace App\Http\Controllers\Admin\Post;

// バリデーションのファイルの読み込み
use App\Http\Requests\PostFormRequest;
use App\Http\Requests\MainCategoryFormRequest;
use App\Http\Requests\SubCategoryFormRequest;
// 使用するモデルのパス
use App\Models\Posts\Post;
use App\Models\Posts\MainCategory;
use App\Models\Posts\SubCategory;
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

    // カテゴリ追加画面の表示
    public function categoryCreate(){
        // モデルからメインカテゴリを取得
        // メインカテゴリの情報を持ちながらカテゴリ追加ページに遷移
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.category_create', compact('main_categories'));
    }

    // メインカテゴリの追加
    // バリデーションをかませる
    public function mainCategoryCreate(MainCategoryFormRequest $request){
        MainCategory::create([
            'main_category' => $request->main_category_name
        ]);
        return redirect()->route('category.create');
    }
    // サブカテゴリの追加
    // バリデーションをかませる
    public function subCategoryCreate(SubCategoryFormRequest $request){
        // メインカテゴリの取得
        $main_category_id=$request->main_category_id;
        // ddd( $main_category_id);

        // サブカテゴリの追加
        $sub_category_get = SubCategory::create([
            'sub_category' => $request->sub_category_name,
            'main_category_id' => $main_category_id,
        ]);
        return redirect()->route('category.create');
    }
}
