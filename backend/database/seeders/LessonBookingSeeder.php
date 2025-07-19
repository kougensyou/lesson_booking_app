<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LessonBooking;
use Carbon\Carbon;

class LessonBookingSeeder extends Seeder
{
    public function run()
    {
        LessonBooking::insert([
            ['booking_time' => Carbon::now(), 'lesson_id' => 1, 'user_id' => 1, 'done_flag' => null],
            ['booking_time' => Carbon::now()->subDay(), 'lesson_id' => 2, 'user_id' => 2, 'done_flag' => null],
            ['booking_time' => Carbon::now()->subDays(2), 'lesson_id' => 3, 'user_id' => 3, 'done_flag' => 1],
        ]);
    }
}