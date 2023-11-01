<?php


use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DBファサードを使用
        User::create([
            'username' => '櫻庭 結菜',
            'email' => 'yunyun.art.19@outlook.jp',
            'password' => Hash::make('yunyun0717'),
            'admin_role' => '10',
            // laravelではパスワードはハッシュ化されて保存されるため、seederでデータを登録する際もハッシュ化させてから行う
        ]);//
        User::create([
            'username' => '櫻庭 七海',
            'email' => 'nanami.art.19@outlook.jp',
            'password' => Hash::make('nanami0717'),
            'admin_role' => '1',
        ]);//
        // ※モデル側にカラムに値を挿入できるようにする記述が必要
    }
}
