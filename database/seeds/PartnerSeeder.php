<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partners')->insert([
            'name' => 'Đại học Bách Khoa Hà Nội',
        ]);
        DB::table('partners')->insert([
            'name' => 'Đại học Quốc Gia Hà Nội',
        ]);
        DB::table('partners')->insert([
            'name' => 'Đại học Giao thông vận tải Hà Nội',
        ]);
        DB::table('partners')->insert([
            'name' => 'Đại học văn hóa Hà Nội',
        ]);
        DB::table('partners')->insert([
            'name' => 'Học viện âm nhạc Hà Nội',
        ]);
    }
}
