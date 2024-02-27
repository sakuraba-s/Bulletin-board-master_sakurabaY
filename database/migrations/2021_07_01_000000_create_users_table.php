<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        // ユーザのテーブル
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('id');
            $table->string('username', 60)->comment('名前');
            $table->string('email', 255)->unique()->comment('メールアドレス');
            // $table->timestamp('email_verified_at')->nullable();
            // ユーザーの電子メールアドレスが確認された日時を格納
            $table->string('password', 255)->comment('パスワード');
            $table->integer('admin_role')->default(10)->nullable()->comment('権限');
            // admin_role が10の場合はユーザー
            // admin_role が1の場合は管理者
            $table->timestamp('created_at')->useCurrent()->comment('登録日時');
            $table->timestamp('updated_at')->default(DB::raw('current_timestamp on update current_timestamp'))->comment('更新日時');
            $table->softDeletes()->comment('削除日時');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
