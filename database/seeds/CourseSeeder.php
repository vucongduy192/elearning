<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
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
        
        while (($row = fgetcsv($file, 0, ',')) !== false) {
            $category_id = DB::table('course_categories')->where('name', $row[0])->first()->id;
            $teacher_id = $category_id + 1; # 6 category corresponding 6 teacher
            DB::table('courses')->insert([
                'name' => $row[1], 
                'overview' => 'edf', 
                'courses_category_id' => $category_id, 
                'teacher_id' => $teacher_id,
            ]);
        }
    }
}
