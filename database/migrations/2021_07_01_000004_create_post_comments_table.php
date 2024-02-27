<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentsTable extends Migration
{
    public function up()
    {
        // 投稿に対するコメントのテーブル
        Schema::create('post_comments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('id');
            $table->integer('user_id')->comment('ユーザーid');
            $table->integer('post_id')->comment('投稿id');
            $table->string('comment')->comment('コメント');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('登録日時');
            $table->timestamp('updated_at')->default(DB::raw('current_timestamp on update current_timestamp'))->comment('更新日時');
            // CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            // →update文をかけた時に自動更新される
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
}
