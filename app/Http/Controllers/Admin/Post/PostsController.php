<?php

namespace App\Http\Controllers\Admin\Post;

// バリデーションのファイルの読み込み
use App\Http\Requests\PostFormRequest;
use App\Http\Requests\MainCategoryFormRequest;
use App\Http\Requests\SubCategoryFormRequest;
use App\Http\Requests\CommentFormRequest;
use App\Http\Requests\EditFormRequest;
// 使用するモデルのパス
use App\Models\Posts\Post;
use App\Models\Posts\Like;
use App\Models\Posts\PostCommentLike;
use App\Models\Posts\PostComment;
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
            'user_id' => Auth::id(),
            'title' => $request->post_title,
            'post' => $request->post_body,
            'sub_category_id' => $post_category_id,
            // nullが許されていないカラムには必ず値を入れること
        ]);

        // リレーション
        // 上記で新規登録したポストテーブルのidを取得しつつテーブルを取得
        // $post = Post::findOrFail($post_get->id);
        // // 投稿とサブカテゴリの紐づけ
        // $post->subCategories()->attach($post_category_id);

        return redirect()->route('top');
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
    // サブカテゴリの削除
    public function subCategoryDelete($id){
        // ddd($id);

        if ( Post::where('sub_category_id', $id)->exists())
        {
        return redirect()->route('category.create')->with('flash_message', '※削除しようとしたサブカテゴリには投稿があります');
        } else {
        SubCategory::findOrFail($id)->delete();
        return redirect()->route('category.create');
    }}
    
    // いいね機能
    // 投稿にいいねをつける
    public function postLike($id){
        // get送信した投稿のidを取得する
        $user_id = Auth::id();
        $post_id = $id;

        // ddd($post_id);

        // いいねをカウントするメソッドをニューする
        // Likeモデル
        $like = new Like;

        // ライクテーブルに新たに登録する
        $like->user_id = $user_id;
        $like->post_id = $post_id;
        $like->save();
        // レコードをDBに保存する
        return response()->json();
        // jsに結果を戻す
        // return redirect()->route('top');
    }
    // コメントいいね機能
    // コメントにいいねをつける
    public function commentLike($id){
        // get送信した投稿のidを取得する
        $user_id = Auth::id();
        $comment_id = $id;

        // ddd($post_id);

        // いいねをカウントするメソッドをニューする
        // Likeモデル
        $like = new PostCommentLike;

        // ライクテーブルに新たに登録する
        $like->user_id = $user_id;
        $like->post_comment_id = $comment_id;
        $like->save();
        // レコードをDBに保存する
        return response()->json();
        // jsに結果を戻す
        // return redirect()->route('top');
    }

    // 投稿にいいねを解除する
    public function postUnLike($id){
        $user_id = Auth::id();
        $post_id = $id;

        $like = new Like;
        $like->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->delete();
        return response()->json();
        // jsに結果を戻す
    }
    // コメントのいいねを解除する
    public function commentUnLike($id){
        $user_id = Auth::id();
        $comment_id = $id;

        $like = new Like;
        $like->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->delete();
        return response()->json();
        // jsに結果を戻す
    }


    // 投稿削除
    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('top');
    }
    // 投稿編集
    // バリデーションをかませる
    public function postEdit(EditFormRequest $request){
        Post::where('id', $request->post_id)->update([
            'title' => $request->post_title,
            'post' => $request->post_body,
            'sub_category_id' => $request->sub_category_id,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    // コメント投稿
    // バリデーションをかませる
    public function commentCreate(CommentFormRequest $request){
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }
    // コメント編集
    // バリデーションをかませる
    public function commentEdit(CommentFormRequest $request){
        PostComment::where('id', $request->comment_id)->update([
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }
    // コメント削除
    public function commentDelete($id,$post_id){
        PostComment::findOrFail($id)->delete();
        return redirect()->route('post.detail', [$post_id]);
    }
}
