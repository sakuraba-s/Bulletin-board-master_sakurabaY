<?php


use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(PostsTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        $this->call(MaincategoriesSeeder::class);
        $this->call(SubcategoriesSeeder::class);
    }

    // テーブル内のデータを一括削除
    // public function run()
    // {
    //     \App\Models\Users\User::truncate();
    // }
}
