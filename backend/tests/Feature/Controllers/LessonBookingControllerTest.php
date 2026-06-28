<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Carbon\Carbon;

class LessonBookingControllerTest extends TestCase
{
    use DatabaseTransactions;

    private function createLessonData(int $bookingUserNum = 0): object
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Booking User',
            'email' => 'booking-user@example.com',
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
            'name' => 'Bookable Lesson',
            'image_path' => null,
            'studio_id' => $studioId,
            'start_time' => Carbon::now()->addDay(),
            'end_time' => Carbon::now()->addDay()->addHour(),
            'explanation' => 'A lesson for booking',
            'max_user_num' => 10,
            'booking_user_num' => $bookingUserNum,
            'lesson_category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return (object) [
            'userId' => $userId,
            'lessonId' => $lessonId,
        ];
    }

    public function test_book_lesson_returns_success(): void
    {
        $data = $this->createLessonData(0);
        $user = \App\Models\User::find($data->userId);

        $response = $this->actingAs($user)->postJson('/api/book_lesson', [
            'lesson_id' => $data->lessonId,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'The lesson was booked successfully.',
        ]);

        // Verify the booking was actually created
        $this->assertDatabaseHas('lesson_booking', [
            'lesson_id' => $data->lessonId,
            'user_id' => $data->userId,
        ]);

        // Verify booking_user_num was incremented
        $this->assertDatabaseHas('lesson', [
            'id' => $data->lessonId,
            'booking_user_num' => 1,
        ]);
    }

    public function test_cancel_lesson_returns_success(): void
    {
        $data = $this->createLessonData(1);

        DB::table('lesson_booking')->insert([
            'booking_time' => Carbon::now(),
            'lesson_id' => $data->lessonId,
            'user_id' => $data->userId,
            'done_flag' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = \App\Models\User::find($data->userId);

        $response = $this->actingAs($user)->postJson('/api/cancel_lesson', [
            'lesson_id' => $data->lessonId,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'The lesson was canceled successfully.',
        ]);

        // Verify the booking was deleted
        $this->assertDatabaseMissing('lesson_booking', [
            'lesson_id' => $data->lessonId,
            'user_id' => $data->userId,
        ]);

        // Verify booking_user_num was decremented
        $this->assertDatabaseHas('lesson', [
            'id' => $data->lessonId,
            'booking_user_num' => 0,
        ]);
    }

    public function test_get_selected_lesson_list_returns_200(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Selected Lesson User',
            'email' => 'selected-lesson@example.com',
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
            'studio_name' => 'Selected Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructorId = DB::table('instructor')->insertGetId([
            'name' => 'Selected Instructor',
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
            'category_name' => 'Selected Cat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $now = Carbon::now();
        $startTime = $now->copy()->addDay()->startOfDay()->addHours(10);
        $endTime = (clone $startTime)->addHour();

        $lessonId = DB::table('lesson')->insertGetId([
            'instructor_id' => $instructorId,
            'name' => 'Selected Lesson',
            'image_path' => null,
            'studio_id' => $studioId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'explanation' => null,
            'max_user_num' => 10,
            'booking_user_num' => 1,
            'lesson_category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('lesson_booking')->insert([
            'booking_time' => $now,
            'lesson_id' => $lessonId,
            'user_id' => $userId,
            'done_flag' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = \App\Models\User::find($userId);
        $selectedYear = $now->year;
        $selectedMonth = $now->month - 1;

        $response = $this->actingAs($user)->getJson("/api/get_selected_lesson_list?selected_year={$selectedYear}&selected_month={$selectedMonth}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'start_time', 'done_flag'],
        ]);
    }

    public function test_book_lesson_requires_auth(): void
    {
        $response = $this->postJson('/api/book_lesson', [
            'lesson_id' => 1,
        ]);

        $response->assertStatus(401);
    }

    public function test_cancel_lesson_requires_auth(): void
    {
        $response = $this->postJson('/api/cancel_lesson', [
            'lesson_id' => 1,
        ]);

        $response->assertStatus(401);
    }
}
