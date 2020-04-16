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
        $fileCourses = fopen(base_path().'/recommendation_system/courses.csv', 'r');
        $row = fgetcsv($fileCourses, 0, ','); # ignore first row
        while (($row = fgetcsv($fileCourses, 0, ',')) !== false) {
            $courses_category_id = DB::table('course_categories')->where('name', $row[2])->first()->id; 
            $teacher_id = rand(1, 2);
            DB::table('courses')->insert([
                'name' => $row[1], 
                'overview' => 'edf', 
                'courses_category_id' => $courses_category_id, 
                'teacher_id' => $teacher_id,
            ]);
        }
    }
}
