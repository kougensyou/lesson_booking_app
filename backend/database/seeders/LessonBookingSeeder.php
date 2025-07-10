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
            ['booking_time' => Carbon::now(), 'lesson_id' => 1, 'cancel_flag' => false, 'user_id' => 1, 'done_flag' => false],
            ['booking_time' => Carbon::now()->subDay(), 'lesson_id' => 2, 'cancel_flag' => false, 'user_id' => 2, 'done_flag' => true],
            ['booking_time' => Carbon::now()->subDays(2), 'lesson_id' => 3, 'cancel_flag' => true,  'user_id' => 3, 'done_flag' => false],
        ]);
    }
}