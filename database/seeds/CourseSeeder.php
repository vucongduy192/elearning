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
                'overview' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce enim nulla.',
                'level' => rand(1, 3),
                'rate' => rand(1, 5),   // TODO current not use => will remove
                'courses_category_id' => $category_id,
                'teacher_id' => $teacher_id,
                'duration_id' => rand(1, 4),
                'partner_id' => rand(1, 5),
            ]);
        }
    }
}
