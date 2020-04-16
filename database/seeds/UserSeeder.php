<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Admin
        DB::table('users')->insert([
            'name' => 'Duy Vu',
            'email' => 'duy123@gmail.com',
            'password' => Hash::make('duy123'),
            'role' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'Quan Hoang',
            'email' => 'quan123@gmail.com',
            'password' => Hash::make('quan123'),
            'role' => 2,
        ]);

        # Teacher
        DB::table('users')->insert([
            'name' => 'Thang Nguyen',
            'email' => 'thang123@gmail.com',
            'password' => Hash::make('thang'),
            'role' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Trung Nguyen',
            'email' => 'trung123@gmail.com',
            'password' => Hash::make('trung123'),
            'role' => 1,
        ]);

        # Users
        $fileUsers = fopen(base_path().'/recommendation_system/users.csv', 'r');
        $row = fgetcsv($fileUsers, 0, ',');
        while (($row = fgetcsv($fileUsers, 0, ',')) !== false) {
            DB::table('users')->insert([
                'name' => $row[0],
                'email' => str_replace(' ', '', strtolower($row[1])).'@gmail.com',
                'password' => Hash::make($row[0]),
                'role' => 0,
            ]);
        }    
    }
}
