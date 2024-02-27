<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToSubCategoriesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // サブカテゴリテーブルに対する外部制約の設定\
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->foreign('main_category_id')
            ->references('id')
            ->on('main_categories')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropForeign(['main_category_id']);

        });
    }
}
