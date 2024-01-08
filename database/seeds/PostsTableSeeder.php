<?php

use Illuminate\Database\Seeder;
use App\Models\Posts\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Post::create([
        'user_id' => '1',
        'post_sub_category_id' => '1',
        'title'=> 'テスト',
        'post' => 'おはよう',
        'event_at' => '2024-01-07'
    ]);
    }
}
