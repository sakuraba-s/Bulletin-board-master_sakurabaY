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

// トップページ表示
Route::get('top/{keyword?}', 'Admin\Post\TopController@top')->name('top');
// 新規投稿ページ表示
// Route::get('top', 'User\Post\PostsController@input')->name('post.input');

// 投稿詳細画面表示
Route::get('top/{id}', 'Admin\Post\TopController@PostDetail')->name('post.detail');
// 投稿画面表示
Route::get('/bulletin_board/input', 'Admin\Post\PostsController@postInput')->name('post.input');
// 投稿機能
Route::post('/bulletin_board/create', 'Admin\Post\PostsController@postCreate')->name('post.create');

// カテゴリ追加画面表示
Route::post('/bulletin_board/category', 'Admin\Post\PostsController@categoryCreate')->name('category.create');
// カテゴリの追加
Route::post('/create/main_category', 'PostsController@mainCategoryCreate')->name('main.category.create');
Route::post('/create/sub_category', 'PostsController@subCategoryCreate')->name('sub.category.create');



// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');

// Route::get('/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');



// ログイン機能
// ユーザ登録機能
// ˧Router.phpに記述あります！


