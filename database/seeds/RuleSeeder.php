<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileCategories = fopen(base_path().'/recommendation_system/categories.csv', 'r');
        $categories = fgetcsv($fileCategories, 0, ','); # ignore first row
        // $categories = array_slice($row, 1);
        while (($row = fgetcsv($fileCategories, 0, ',')) !== false) {
            for ($i = 1; $i < sizeof($row); $i++) {
                $cat_id1 = DB::table('course_categories')->where('name', $row[0])->first()->id;
                $cat_id2 = DB::table('course_categories')->where('name', $categories[$i])->first()->id;
                
                if (   DB::table('category_rules')->where('cat_id1', $cat_id1)->where('cat_id2', $cat_id2)->first()
                    || DB::table('category_rules')->where('cat_id1', $cat_id2)->where('cat_id2', $cat_id1)->first() )
                    continue;
                if ($cat_id1 == $cat_id2)
                    continue;

                DB::table('category_rules')->insert([
                    'cat_id1' => $cat_id1,
                    'cat_id2' => $cat_id2,
                    'weight' => $row[$i],
                ]);
            }
        }    
    }
}
