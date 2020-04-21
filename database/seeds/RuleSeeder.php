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
        $fileRules = fopen(base_path().'/SeedSQL/rules.csv', 'r');
        $row = fgetcsv($fileRules, 0, ','); # ignore first row
        while (($row = fgetcsv($fileRules, 0, ',')) !== false) {
            $cat_id1 = DB::table('course_categories')->where('name', $row[0])->first()->id;
            $cat_id2 = DB::table('course_categories')->where('name', $row[1])->first()->id;

            DB::table('category_rules')->insert([
                'cat_id1' => $cat_id1,
                'cat_id2' => $cat_id2,
                'weight' => $row[2],
            ]);
        }    
    }
}
