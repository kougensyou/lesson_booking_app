<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FirstBookingRequestTest extends TestCase
{
    use DatabaseTransactions;

    public function test_first_booking_validation_fails_without_name(): void
    {
        $response = $this->postJson('/api/validate_first_lesson', [
            'first_booking' => [
                'user' => [
                    'email' => 'test@example.com',
                    'birth_date' => '1990-01-01',
                ],
                'selected_lesson' => [
                    'lesson_category_name' => 'Pilates',
                    'studio_name' => 'Test Studio',
                    'lesson_day' => '1/15',
                    'lesson_time' => '10:00 - 11:00',
                    'lesson_name' => 'Basic Pilates',
                ],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_first_booking_validation_fails_without_email(): void
    {
        $response = $this->postJson('/api/validate_first_lesson', [
            'first_booking' => [
                'user' => [
                    'name' => 'Test User',
                    'birth_date' => '1990-01-01',
                ],
                'selected_lesson' => [
                    'lesson_category_name' => 'Pilates',
                    'studio_name' => 'Test Studio',
                    'lesson_day' => '1/15',
                    'lesson_time' => '10:00 - 11:00',
                    'lesson_name' => 'Basic Pilates',
                ],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_first_booking_validation_fails_with_invalid_email(): void
    {
        $response = $this->postJson('/api/validate_first_lesson', [
            'first_booking' => [
                'user' => [
                    'name' => 'Test User',
                    'email' => 'invalid-email',
                    'birth_date' => '1990-01-01',
                ],
                'selected_lesson' => [
                    'lesson_category_name' => 'Pilates',
                    'studio_name' => 'Test Studio',
                    'lesson_day' => '1/15',
                    'lesson_time' => '10:00 - 11:00',
                    'lesson_name' => 'Basic Pilates',
                ],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_first_booking_validation_fails_without_birth_date(): void
    {
        $response = $this->postJson('/api/validate_first_lesson', [
            'first_booking' => [
                'user' => [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                ],
                'selected_lesson' => [
                    'lesson_category_name' => 'Pilates',
                    'studio_name' => 'Test Studio',
                    'lesson_day' => '1/15',
                    'lesson_time' => '10:00 - 11:00',
                    'lesson_name' => 'Basic Pilates',
                ],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['birth_date']);
    }

    public function test_first_booking_validation_fails_without_lesson_name(): void
    {
        $response = $this->postJson('/api/validate_first_lesson', [
            'first_booking' => [
                'user' => [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'birth_date' => '1990-01-01',
                ],
                'selected_lesson' => [
                    'lesson_category_name' => 'Pilates',
                    'studio_name' => 'Test Studio',
                    'lesson_day' => '1/15',
                    'lesson_time' => '10:00 - 11:00',
                ],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['lesson_name']);
    }

    public function test_first_booking_validation_fails_without_studio_name(): void
    {
        $response = $this->postJson('/api/validate_first_lesson', [
            'first_booking' => [
                'user' => [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'birth_date' => '1990-01-01',
                ],
                'selected_lesson' => [
                    'lesson_category_name' => 'Pilates',
                    'lesson_day' => '1/15',
                    'lesson_time' => '10:00 - 11:00',
                    'lesson_name' => 'Basic Pilates',
                ],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['studio_name']);
    }

    public function test_first_booking_validation_passes_with_valid_data(): void
    {
        $response = $this->postJson('/api/validate_first_lesson', [
            'first_booking' => [
                'user' => [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'birth_date' => '1990-01-01',
                ],
                'selected_lesson' => [
                    'lesson_category_name' => 'Pilates',
                    'studio_name' => 'Test Studio',
                    'lesson_day' => '1/15',
                    'lesson_time' => '10:00 - 11:00',
                    'lesson_name' => 'Basic Pilates',
                ],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Validation passed',
        ]);
    }
}
