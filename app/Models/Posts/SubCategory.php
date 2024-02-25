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
    public function mainCategory(){
        // リレーションの定義
        return $this->belongsTo('App\Models\Posts\MainCategory');
    }

    // 中間テーブルのリレーション
    public function posts(){
        // リレーションの定義
        // 投稿とサブカテゴリ―との中間テーブル
        // 投稿＿サブカテゴリ
        return $this->belongsToMany('App\Models\Posts\Post', 'post_sub_categories', 'sub_category_id', 'post_id')->withPivot('id');
    }
}
