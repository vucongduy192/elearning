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
        $file = fopen(base_path().'/SeedSQL/enroll_train.csv', 'r');
        $row = fgetcsv($file, 0, ','); # ignore first row
        while (($row = fgetcsv($file, 0, ',')) !== false) {
            $course_id = DB::table('courses')
                ->where('name', $row[5])
                ->first()->id;

            $student_id = DB::table('users')->where('name', $row[4])
                ->join('students', 'users.id', '=', 'students.user_id')        
                ->select(['students.id as id', ])
                ->first()->id;

            DB::table('enrolls')->insert([
                'course_id' => $course_id,
                'student_id' => $student_id,
            ]);
        }
    }
}
