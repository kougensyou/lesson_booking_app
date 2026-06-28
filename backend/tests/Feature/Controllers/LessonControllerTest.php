<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Carbon\Carbon;

class LessonControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_lesson_category_list_returns_200(): void
    {
        DB::table('lesson_category')->insert([
            ['category_name' => 'Pilates', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Yoga', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $response = $this->getJson('/api/get_lesson_category_list');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'category_name'],
        ]);
    }

    public function test_get_time_options_returns_200(): void
    {
        $response = $this->getJson('/api/get_time_options');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'start_time_options',
            'end_time_options',
        ]);
    }

    public function test_get_next_lesson_data_returns_200(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Next Lesson User',
            'email' => 'next-lesson@example.com',
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
            'studio_name' => 'Next Lesson Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructorId = DB::table('instructor')->insertGetId([
            'name' => 'Next Lesson Instructor',
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
            'category_name' => 'Next Lesson Cat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lessonId = DB::table('lesson')->insertGetId([
            'instructor_id' => $instructorId,
            'name' => 'Future Lesson',
            'image_path' => null,
            'studio_id' => $studioId,
            'start_time' => Carbon::now()->addDay(),
            'end_time' => Carbon::now()->addDay()->addHour(),
            'explanation' => 'Test lesson',
            'max_user_num' => 10,
            'booking_user_num' => 1,
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

        $user = \App\Models\User::find($userId);
        $response = $this->actingAs($user)->getJson('/api/get_next_lesson_data');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonStructure([
            '*' => [
                'id', 'studio_name', 'lesson_name',
                'start_time', 'end_time', 'lesson_time',
                'instructor_name',
            ],
        ]);
    }

    public function test_get_next_lesson_data_requires_auth(): void
    {
        $response = $this->getJson('/api/get_next_lesson_data');

        $response->assertStatus(401);
    }

    public function test_get_studio_lesson_data_returns_200(): void
    {
        $studioId = DB::table('studio')->insertGetId([
            'studio_name' => 'Studio Lesson Data',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructorId = DB::table('instructor')->insertGetId([
            'name' => 'Studio Lesson Instructor',
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
            'category_name' => 'Studio Lesson Cat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $startTime = Carbon::now()->addDay()->startOfDay()->addHours(10);
        $endTime = (clone $startTime)->addHour();

        DB::table('lesson')->insert([
            'instructor_id' => $instructorId,
            'name' => 'Studio Test Lesson',
            'image_path' => null,
            'studio_id' => $studioId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'explanation' => 'Test lesson for studio lesson data',
            'max_user_num' => 10,
            'booking_user_num' => 0,
            'lesson_category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $fromDate = Carbon::now()->format('Y-m-d');
        $toDate = Carbon::now()->addMonth()->format('Y-m-d');

        $response = $this->getJson("/api/get_studio_lesson_data?studio_id={$studioId}&from_date={$fromDate}&to_date={$toDate}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'studio_lesson_list',
            'studio_data' => ['id', 'studio_name'],
            'time_options',
        ]);
    }
}
