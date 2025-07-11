<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;

class LessonSeeder extends Seeder
{
    public function run()
    {
        Lesson::insert([
            ['instructor_id' => 1, 'name' => 'Pilates Basic', 'studio_id' => 1, 'start_time' => now(), 'end_time' => now()->addHours(1), 'explanation' => 'Recommended class for people who want to learn the basics of Pilates', 'max_user_num' => 15, 'lesson_category_id' => 1],
            ['instructor_id' => 2, 'name' => 'Pilates Intermediate', 'studio_id' => 1, 'start_time' => now(), 'end_time' => now()->addHours(1), 'explanation' => 'A class for those who have mastered the basics and want to deepen their practice.', 'max_user_num' => 15, 'lesson_category_id' => 1],
            ['instructor_id' => 3, 'name' => 'Yoga Basic', 'studio_id' => 1, 'start_time' => now(), 'end_time' => now()->addHours(1), 'explanation' => 'An introductory class for those new to yoga.', 'max_user_num' => 8, 'lesson_category_id' => 2],
        ]);
    }
}