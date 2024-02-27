<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostSubCategoriesTable extends Migration
{
    public function up()
    {
        // 投稿とサブカテゴリをまとめたテーブル
        // 一対多
        // 投稿一つにサブカテゴリは一つ
        // サブカテゴリ一つに対して紐づく投稿はいくつかある
        Schema::create('post_sub_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('id');
            $table->integer('post_id')->index()->comment('投稿のid');
            $table->integer('sub_category_id')->index()->comment('サブカテゴリーid');
            $table->timestamp('created_at')->nullable()->comment('登録日時');
        });
    }

    // サブカテゴリと投稿の中間テーブル


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_sub_categories');
    }
}
