<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            CategorySeeder::class,
            DurationSeeder::class,
            PartnerSeeder::class,
            CourseSeeder::class,
            RuleSeeder::class,
            EnrollSeeder::class,
        ]);
    }
}
