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
        User::create([
            'username' => '櫻庭 結菜',
            'email' => 'yunyun.art.19@outlook.jp',
            'password' => 'yunyun0717',
            'admin_role' => '10',
        ]);//
        User::create([
            'username' => '櫻庭 七海',
            'email' => 'nanami.art.19@outlook.jp',
            'password' => 'nanami0717',
            'admin_role' => '1',
        ]);//
        
    }
}
