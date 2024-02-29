<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{

    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category',
    ];
    public function subCategories(){
    // メインカテゴリ＿サブカテゴリの関係
    // ※一対多
    // 一つのメインカテゴリは多数のサブカテゴリを持ちうる
    // 主→従
        return $this->hasMany('App\Models\Posts\SubCategory');
    }

}
