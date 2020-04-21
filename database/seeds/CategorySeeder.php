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
        $file = fopen(base_path().'/SeedSQL/courses.csv', 'r');
        $row = fgetcsv($file, 0, ',');
        $unique = [];

        while (($row = fgetcsv($file, 0, ',')) !== false) {
            if (in_array($row[0], $unique))
                continue;

            array_push($unique, $row[0]);
            DB::table('course_categories')->insert([
                'name' => $row[0], 
                'overview' => 'abc'
            ]);
        }
    }
}
