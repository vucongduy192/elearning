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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'Admin teacher',
            'email' => 'admin_teacher@gmail.com',
            'password' => Hash::make('admin'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);

        # Teacher []
        DB::table('users')->insert([
            'name' => 'Thang Nguyen',
            'email' => 'thang123@gmail.com',
            'password' => Hash::make('thang123'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Trung Nguyen',
            'email' => 'trung123@gmail.com',
            'password' => Hash::make('trung123'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Duc Nguyen',
            'email' => 'duc123@gmail.com',
            'password' => Hash::make('duc123'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Dat Nguyen',
            'email' => 'dat123@gmail.com',
            'password' => Hash::make('dat123'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Quang Nguyen',
            'email' => 'quang123@gmail.com',
            'password' => Hash::make('quang123'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Giang Nguyen',
            'email' => 'giang123@gmail.com',
            'password' => Hash::make('giang123'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);


        DB::table('users')->insert([
            'name' => 'Dai Nguyen',
            'email' => 'dai123@gmail.com',
            'password' => Hash::make('dai123'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Hoang Nguyen',
            'email' => 'hoang123@gmail.com',
            'password' => Hash::make('hoang123'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Manh Nguyen',
            'email' => 'manh123@gmail.com',
            'password' => Hash::make('manh123'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Cong Nguyen',
            'email' => 'cong123@gmail.com',
            'password' => Hash::make('cong123'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'role_id' => 1,
        ]);


        # Users
        $fileUsers = fopen(base_path().'/SeedSQL/users.csv', 'r');
        $row = fgetcsv($fileUsers, 0, ',');
        while (($row = fgetcsv($fileUsers, 0, ',')) !== false) {
            DB::table('users')->insert([
                'name' => $row[0],
                'email' => str_replace(' ', '', strtolower($row[0])).'@gmail.com',
                'first_name' => explode(' ', $row[1])[0],
                'last_name' => explode(' ', $row[1])[1],
                'password' => Hash::make($row[0]),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'role_id' => 0,
            ]);
        }
    }
}
