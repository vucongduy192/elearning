<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users')->where('id', '>', 4)->get();
        foreach ($users as $user) {
            DB::table('students')->insert([
                'school' => 'Đại học Bách Khoa Hà Nội',
                'major' => 'CNTT',
                'user_id' => $user->id,
            ]);
        }
    }
}
