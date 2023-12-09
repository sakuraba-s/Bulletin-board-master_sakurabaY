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
Route::middleware(['verified'])->group(function(){
// トップ画面
Route::get('top', 'Admin\Post\TopController@top')->name('top');

// Route::post('register/users', 'Auth\Register\RegisterController@registerUser')->name('registerUser');
});

// Route::get('top', 'Admin\Post\TopController@top')->name('top');



// Route::get('/email/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');

// Route::get('/verify', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');



// ログイン機能
// ユーザ登録機能
// ˧Router.phpに記述あります！


