<?php

namespace Tests\Feature\Repositories;

use App\Repositories\LessonBookingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Carbon\Carbon;

class LessonBookingRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_lesson_booking_creates_record(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Booking Create User',
            'email' => 'bk-create@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $studioId = DB::table('studio')->insertGetId([
            'studio_name' => 'Booking Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructorId = DB::table('instructor')->insertGetId([
            'name' => 'Booking Instructor',
            'image_path' => null,
            'studio_id' => $studioId,
            'introduction' => null,
            'from_place' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $categoryId = 100;
        DB::table('lesson_category')->insert([
            'id' => $categoryId,
            'category_name' => 'Booking Category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lessonId = DB::table('lesson')->insertGetId([
            'instructor_id' => $instructorId,
            'name' => 'Booking Lesson',
            'image_path' => null,
            'studio_id' => $studioId,
            'start_time' => Carbon::now()->addDay(),
            'end_time' => Carbon::now()->addDay()->addHour(),
            'explanation' => null,
            'max_user_num' => 10,
            'booking_user_num' => 0,
            'lesson_category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $bookingData = [
            'booking_time' => Carbon::now(),
            'lesson_id' => $lessonId,
            'user_id' => $userId,
            'done_flag' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        (new LessonBookingRepository())->createLessonBooking($bookingData);

        $record = DB::table('lesson_booking')
            ->where('lesson_id', $lessonId)
            ->where('user_id', $userId)
            ->first();

        $this->assertNotNull($record);
        $this->assertSame($userId, $record->user_id);
        $this->assertSame($lessonId, $record->lesson_id);
        $this->assertNull($record->done_flag);
    }

    public function test_delete_lesson_booking_removes_record(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Booking Delete User',
            'email' => 'bk-delete@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $studioId = DB::table('studio')->insertGetId([
            'studio_name' => 'Delete Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructorId = DB::table('instructor')->insertGetId([
            'name' => 'Delete Instructor',
            'image_path' => null,
            'studio_id' => $studioId,
            'introduction' => null,
            'from_place' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $categoryId = 100;
        DB::table('lesson_category')->insert([
            'id' => $categoryId,
            'category_name' => 'Delete Category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lessonId = DB::table('lesson')->insertGetId([
            'instructor_id' => $instructorId,
            'name' => 'Delete Lesson',
            'image_path' => null,
            'studio_id' => $studioId,
            'start_time' => Carbon::now()->addDay(),
            'end_time' => Carbon::now()->addDay()->addHour(),
            'explanation' => null,
            'max_user_num' => 10,
            'booking_user_num' => 0,
            'lesson_category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('lesson_booking')->insert([
            'booking_time' => Carbon::now(),
            'lesson_id' => $lessonId,
            'user_id' => $userId,
            'done_flag' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        (new LessonBookingRepository())->deleteLessonBooking($userId, $lessonId);

        $record = DB::table('lesson_booking')
            ->where('lesson_id', $lessonId)
            ->where('user_id', $userId)
            ->first();

        $this->assertNull($record);
    }

    public function test_increment_booking_user_num_increases_count(): void
    {
        $studioId = DB::table('studio')->insertGetId([
            'studio_name' => 'Increment Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructorId = DB::table('instructor')->insertGetId([
            'name' => 'Increment Instructor',
            'image_path' => null,
            'studio_id' => $studioId,
            'introduction' => null,
            'from_place' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $categoryId = 100;
        DB::table('lesson_category')->insert([
            'id' => $categoryId,
            'category_name' => 'Increment Category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lessonId = DB::table('lesson')->insertGetId([
            'instructor_id' => $instructorId,
            'name' => 'Increment Lesson',
            'image_path' => null,
            'studio_id' => $studioId,
            'start_time' => Carbon::now()->addDay(),
            'end_time' => Carbon::now()->addDay()->addHour(),
            'explanation' => null,
            'max_user_num' => 10,
            'booking_user_num' => 5,
            'lesson_category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        (new LessonBookingRepository())->incrementBookingUserNum($lessonId);

        $lesson = DB::table('lesson')->where('id', $lessonId)->first();
        $this->assertSame(6, $lesson->booking_user_num);
    }

    public function test_decrement_booking_user_num_decreases_count(): void
    {
        $studioId = DB::table('studio')->insertGetId([
            'studio_name' => 'Decrement Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructorId = DB::table('instructor')->insertGetId([
            'name' => 'Decrement Instructor',
            'image_path' => null,
            'studio_id' => $studioId,
            'introduction' => null,
            'from_place' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $categoryId = 100;
        DB::table('lesson_category')->insert([
            'id' => $categoryId,
            'category_name' => 'Decrement Category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lessonId = DB::table('lesson')->insertGetId([
            'instructor_id' => $instructorId,
            'name' => 'Decrement Lesson',
            'image_path' => null,
            'studio_id' => $studioId,
            'start_time' => Carbon::now()->addDay(),
            'end_time' => Carbon::now()->addDay()->addHour(),
            'explanation' => null,
            'max_user_num' => 10,
            'booking_user_num' => 5,
            'lesson_category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        (new LessonBookingRepository())->decrementBookingUserNum($lessonId);

        $lesson = DB::table('lesson')->where('id', $lessonId)->first();
        $this->assertSame(4, $lesson->booking_user_num);
    }
}
