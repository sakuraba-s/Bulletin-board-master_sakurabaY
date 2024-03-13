<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();
// メール確認の機能を有効にする
Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home');


// メール確認済みのverifiedユーザー以外は各ルートにアクセスできない
// Route::middleware(['verified'])->group(function(){
// // トップ画面
// Route::get('top', 'Admin\Post\TopController@top')->name('top');
// Route::post('register/users', 'Auth\Register\RegisterController@registerUser')->name('registerUser');
// });
// ログインユーザのみアクセス可能なページ
Route::group(['middleware' => 'auth'], function(){

    // トップページ表示
    // 検索した結果があれば絞り込んだものを表示させる
    Route::get('top/{keyword?}', 'Admin\Post\TopController@top')->name('top');
    // 新規投稿ページ表示
    // Route::get('top', 'User\Post\PostsController@input')->name('post.input');

    // いいねをする※ajax経由 非同期通信！
    Route::get('/like/post/{id}', 'Admin\Post\PostsController@postLike')->name('post.like');
    // いいねを解除する
    Route::get('/unlike/post/{id}', 'Admin\Post\PostsController@postUnLike')->name('post.unlike');
    // カッコ部分に引き渡したいパラメータをセットする

    // 投稿詳細画面表示
    Route::get('/bulletin_board/detail/{id}', 'Admin\Post\TopController@PostDetail')->name('post.detail');
    // 投稿画面表示
    Route::get('/bulletin_board/input', 'Admin\Post\PostsController@postInput')->name('post.input');
    // 投稿機能
    Route::post('/bulletin_board/create', 'Admin\Post\PostsController@postCreate')->name('post.create');
    // 投稿の編集
    Route::post('/bulletin_board/edit', 'Admin\Post\PostsController@postEdit')->name('post.edit');
    // 削除
    Route::get('/bulletin_board/delete/{id}', 'Admin\Post\PostsController@postDelete')->name('post.delete');
    // コメント投稿
    Route::post('/comment/create', 'Admin\Post\PostsController@commentCreate')->name('comment.create');
    // コメントの編集
    Route::post('/comment/edit', 'Admin\Post\PostsController@commentEdit')->name('comment.edit');
    // コメント削除
    Route::get('/comment/delete/{id}/{post_id}', 'Admin\Post\PostsController@commentDelete')->name('comment.delete');

    // カテゴリ追加画面表示
    Route::get('/bulletin_board/category', 'Admin\Post\PostsController@categoryCreate')->name('category.create');
    // カテゴリの追加
    Route::post('/create/main_category', 'Admin\Post\PostsController@mainCategoryCreate')->name('main.category.create');
    Route::post('/create/sub_category', 'Admin\Post\PostsController@subCategoryCreate')->name('sub.category.create');
    // カテゴリの削除
    Route::get('/delete/sub_category/{id}', 'Admin\Post\PostsController@subCategoryDelete')->name('sub.category.delete');
});



// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');

// Route::get('/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');



// ログイン機能
// ユーザ登録機能
// ˧Router.phpに記述あります！


