<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileCourses = fopen(base_path().'/recommendation_system/train/enroll_train.csv', 'r');
        $row = fgetcsv($fileCourses, 0, ','); # ignore first row
        while (($row = fgetcsv($fileCourses, 0, ',')) !== false) {
            
        }
    }
}
