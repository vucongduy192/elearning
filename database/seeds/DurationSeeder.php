<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('durations')->insert([
            'name' => '1-3 Months',
        ]);
        DB::table('durations')->insert([
            'name' => '1-4 Weeks',
        ]);
        DB::table('durations')->insert([
            'name' => 'Less Than 2 Hours',
        ]);
        DB::table('durations')->insert([
            'name' => '3+ Months',
        ]);
    }
}
