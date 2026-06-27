<?php

namespace Tests\Unit\Services;

use App\Repositories\LessonRepository;
use App\Services\LessonService;
use Tests\TestCase;

class LessonServiceTest extends TestCase
{
    public function test_get_lesson_detail_formats_repository_result(): void
    {
        $repository = new class extends LessonRepository {
            public function getLessonDetail($userId, $lessonId): object
            {
                return (object) [
                    'studio' => (object) [
                        'id' => 10,
                        'studio_name' => 'Shibuya Studio',
                    ],
                    'instructor' => (object) [
                        'name' => 'Taro Yamada',
                        'introduction' => 'Yoga instructor',
                        'image_path' => '/images/instructor/yamada.png',
                    ],
                    'lessonBookings' => collect([
                        (object) ['done_flag' => false],
                    ]),
                    'name' => 'Morning Yoga',
                    'explanation' => 'Morning yoga lesson',
                    'image_path' => '/images/lesson/morning.png',
                    'start_time' => '2026-07-01 09:00:00',
                    'end_time' => '2026-07-01 10:30:00',
                    'max_user_num' => 20,
                    'booking_user_num' => 12,
                ];
            }
        };

        $service = new LessonService($repository);

        $result = $service->getLessonDetail(1, 100);

        $this->assertSame(10, $result->studio_id);
        $this->assertSame('Shibuya Studio', $result->studio_name);
        $this->assertSame('Morning Yoga', $result->lesson_name);
        $this->assertSame('/storage/images/lesson/morning.png', $result->lesson_image_url);
        $this->assertSame('7/1', $result->lesson_day);
        $this->assertSame('9:00 - 10:30', $result->lesson_time);
        $this->assertTrue($result->empty_flag);
        $this->assertTrue($result->booked_flag);
        $this->assertFalse($result->done_flag);
        $this->assertSame('/storage/images/instructor/yamada.png', $result->instructor_image_url);
    }
}
