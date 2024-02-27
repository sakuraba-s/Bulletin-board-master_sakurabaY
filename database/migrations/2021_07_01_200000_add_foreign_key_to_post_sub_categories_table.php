<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToPostSubCategoriesTable extends Migration
{
    public function up()
    {
        // 投稿とサブカテゴリをまとめたテーブルテーブルに対する外部制約の設定
        Schema::table('post_sub_categories', function (Blueprint $table) {

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('post_sub_categories', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
        });
    }
}
