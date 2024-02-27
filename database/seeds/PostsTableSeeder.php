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
        'title'=> 'きょうのてんき',
        'post' => 'おはようきょうはいい天気ですね。いい一日になりますように。',
    ]);
    }
}
