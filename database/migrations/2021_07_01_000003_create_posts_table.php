<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        // 投稿のテーブル
        Schema::create('posts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('id');
            $table->integer('user_id')->comment('ユーザーid');
            $table->string('title')->comment('タイトル');
            $table->integer('sub_category_id')->comment('サブカテゴリid');
            $table->string('post')->comment('投稿内容');
            $table->timestamp('created_at')->useCurrent()->comment('登録日時');
            $table->timestamp('updated_at')->default(DB::raw('current_timestamp on update current_timestamp'))->comment('更新日時');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
