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
Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home');


// メール確認済みのverifiedユーザー以外は各ルートにアクセスできない
Route::middleware(['verified'])->group(function(){
// トップ画面
Route::get('top', 'Admin\Post\TopController@top')->name('top');


});


// ログイン機能
Route::post('/login', 'Auth\Login\LoginController@login')->name('login');

// ユーザー登録機能
Route::post('/register', 'Auth\Register\RegisterController@Register')->name('register');

