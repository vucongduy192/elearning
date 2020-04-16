<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileCategories = fopen(base_path().'/recommendation_system/categories.csv', 'r');
        $row = fgetcsv($fileCategories, 0, ',');
        for ($i = 1; $i < sizeof($row); $i++) {
            DB::table('course_categories')->insert([
                'name' => $row[$i],
                'overview' => 'abc',
                'thumbnail' => public_path().'/images/image_placeholder.png',
            ]);
        }        
    }
}
