<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use Carbon\Carbon;

class LessonSeeder extends Seeder
{
    public function run()
    {
        $lessons = [
            ['instructor_id' => 1, 'name' => 'Pilates Basic', 'image_path' => '/images/lesson/lesson_1.png', 'studio_id' => 1, 'explanation' => 'Recommended class for people who want to learn the basics of Pilates', 'max_user_num' => 15, 'booking_user_num' => 0, 'lesson_category_id' => 1],
            ['instructor_id' => 2, 'name' => 'Pilates Intermediate', 'image_path' => '/images/lesson/lesson_2.png', 'studio_id' => 1, 'explanation' => 'A class for those who have mastered the basics and want to deepen their practice.', 'max_user_num' => 15, 'booking_user_num' => 0, 'lesson_category_id' => 1],
            ['instructor_id' => 3, 'name' => 'Yoga Basic', 'image_path' => '/images/lesson/lesson_3.png', 'studio_id' => 1, 'explanation' => 'An introductory class for those new to yoga.', 'max_user_num' => 8, 'booking_user_num' => 0, 'lesson_category_id' => 2],
        ];

        $insertData = [];

        foreach ($lessons as $lesson) {
            $startTime = Carbon::create(2025, 10, 14, 7, 0, 0);
            for ($i = 0; $i < 52; $i++) {
                $insertData[] = array_merge($lesson, [
                    'start_time' => $startTime->copy(),
                    'end_time' => $startTime->copy()->addHour(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $startTime->addWeek();
            }
        }

        Lesson::insert($insertData);
    }
}