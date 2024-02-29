<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostLikesTable extends Migration
{
    public function up()
    {
        // 投稿に対する「好き」の中間テーブル
        Schema::create('post_likes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('id');
            $table->integer('user_id')->comment('ユーザーid');
            $table->integer('post_id')->comment('投稿id');
            $table->timestamp('created_at')->useCurrent()->comment('登録日時');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_likes');
    }
}
