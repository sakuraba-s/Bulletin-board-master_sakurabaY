<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyPostCommentFavoritesTable extends Migration
{
    public function up()
    {
        // 外部性制約　中間テーブル
        // コメントに対する「好き」の中間テーブルに対する外部制約の設定
        Schema::table('post_comment_favorites', function (Blueprint $table) {

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                // 中間テーブルにある「user_id」カラムに対して制約を設定する
                // 「users」テーブルに存在する「id」でなければならない

            $table->foreign('post_comment_id')
                ->references('id')
                ->on('post_comments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                // 中間テーブルにある「post_comment_id」カラムに対して制約を設定する
        });
    }

    public function down()
    {
        Schema::table('post_comment_favorites', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['post_comment_id']);
        });
    }
}
