<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnglishSeeder extends Seeder
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

        $id = 1;
        while (($row = fgetcsv($file, 0, ',')) !== false) {
            DB::table('courses')->where('id', $id)
                ->update([
                    'name_en' => $row[3],
                    'name' => $row[1]
                ]);
            $id++;
        }
    }
}
