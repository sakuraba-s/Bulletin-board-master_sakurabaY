<?php

use Illuminate\Database\Seeder;
use App\Models\Posts\SubCategory;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SubCategory::create([
            'main_category_id' => '1',
            'sub_category' => 'バイク',
        ]);
    }
}
