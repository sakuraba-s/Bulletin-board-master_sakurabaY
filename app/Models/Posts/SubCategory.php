<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{

    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];

    // サブカテゴリは一つのメインカテゴリに属する
    // 一対多
    // 従→主
    public function mainCategory(){
        return $this->belongsTo('App\Models\Posts\MainCategory');
    }

    // 投稿内容＿サブカテゴリの関係
    // ※一対多
    // 主→従
    public function posts(){
        return $this->hasMany('App\Models\Posts\Post');
    }
}
