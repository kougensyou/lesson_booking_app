<?php

namespace Tests\Feature\Repositories;

use App\Repositories\LessonRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Carbon\Carbon;

class LessonRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_lesson_category_list_returns_all_categories(): void
    {
        DB::table('lesson_category')->insert([
            ['category_name' => 'Test Category A', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Test Category B', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Test Category C', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $result = (new LessonRepository())->getLessonCategoryList();

        $this->assertGreaterThanOrEqual(3, $result->count());
        $categoryNames = $result->pluck('category_name')->all();
        $this->assertContains('Test Category A', $categoryNames);
        $this->assertContains('Test Category B', $categoryNames);
        $this->assertContains('Test Category C', $categoryNames);
    }

    public function test_get_studio_data_returns_studio_by_id(): void
    {
        $studioId = DB::table('studio')->insertGetId([
            'studio_name' => 'Test Studio Detail',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $result = (new LessonRepository())->getStudioData($studioId);

        $this->assertSame($studioId, $result->id);
        $this->assertSame('Test Studio Detail', $result->studio_name);
    }

    public function test_get_lesson_detail_returns_lesson_with_relations(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Lesson Detail User',
            'email' => 'detail-user@example.com',
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
            'studio_name' => 'Detail Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructorId = DB::table('instructor')->insertGetId([
            'name' => 'Detail Instructor',
            'image_path' => '/images/instructor/detail.png',
            'studio_id' => $studioId,
            'introduction' => 'Test introduction',
            'from_place' => 'Tokyo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $categoryId = 100;
        DB::table('lesson_category')->insert([
            'id' => $categoryId,
            'category_name' => 'Detail Category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lessonId = DB::table('lesson')->insertGetId([
            'instructor_id' => $instructorId,
            'name' => 'Detail Lesson',
            'image_path' => null,
            'studio_id' => $studioId,
            'start_time' => Carbon::now()->addDay(),
            'end_time' => Carbon::now()->addDay()->addHour(),
            'explanation' => 'Detail lesson explanation',
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

        $result = (new LessonRepository())->getLessonDetail($userId, $lessonId);

        $this->assertSame($lessonId, $result->id);
        $this->assertSame('Detail Lesson', $result->name);
        $this->assertSame('Detail Studio', $result->studio->studio_name);
        $this->assertSame('Detail Instructor', $result->instructor->name);
        $this->assertCount(1, $result->lessonBookings);
        $this->assertSame($userId, $result->lessonBookings->first()->user_id);
    }
}
