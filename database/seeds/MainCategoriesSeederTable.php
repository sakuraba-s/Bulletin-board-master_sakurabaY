<?php

use Illuminate\Database\Seeder;
use App\Models\Posts\MainCategory;

class MainCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MainCategory::create([
            'main_category' => '趣味',
        ]);
    }
}
