<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->insert([
            'workplace' => 'Đại học Bách Khoa Hà Nội',
            'expert' => 'Giảng viên',
            'user_id' => 3
        ]);

        DB::table('teachers')->insert([
            'workplace' => 'Đại học Bách Khoa Hà Nội',
            'expert' => 'Tiến sỹ',
            'user_id' => 4
        ]);
    }
}
