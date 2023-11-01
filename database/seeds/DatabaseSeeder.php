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
        $this->call(UsersTableSeeder::class);
    }

    // テーブル内のデータを一括削除
    // public function run()
    // {
    //     \App\Models\Users\User::truncate();
    // }
}
