<?php

namespace Database\Seeders;

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
            InfoSeeder::class,
            InstructorSeeder::class,
            LessonBookingSeeder::class,
            LessonCategorySeeder::class,
            LessonSeeder::class,
            StudioCategorySeeder::class,
            StudioSeeder::class
        ]);
    }
}
