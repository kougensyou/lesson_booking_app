<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserUpdateRequestTest extends TestCase
{
    use DatabaseTransactions;

    private function createAuthenticatedUser(): object
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Auth User',
            'email' => 'auth-user@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => '123-4567',
            'tel_no' => '080-1234-5678',
            'address' => 'Tokyo Test 1-1-1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = \App\Models\User::find($userId);
        $this->actingAs($user);

        return (object) ['id' => $userId];
    }

    public function test_user_update_validation_fails_without_name(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/update_user', [
            'email' => 'test@example.com',
            'zip_code' => '123-4567',
            'address' => 'Tokyo Test',
            'birth_date' => '1990-01-01',
            'tel_no' => '080-1234-5678',
            'image_url' => '/images/user/test.png',
            'password' => 'password123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_user_update_validation_fails_with_long_name(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/update_user', [
            'name' => str_repeat('あ', 31),
            'email' => 'test@example.com',
            'zip_code' => '123-4567',
            'address' => 'Tokyo Test',
            'birth_date' => '1990-01-01',
            'tel_no' => '080-1234-5678',
            'image_url' => '/images/user/test.png',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_user_update_validation_fails_without_email(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/update_user', [
            'name' => 'Test User',
            'zip_code' => '123-4567',
            'address' => 'Tokyo Test',
            'birth_date' => '1990-01-01',
            'tel_no' => '080-1234-5678',
            'image_url' => '/images/user/test.png',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_user_update_validation_fails_with_long_email(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/update_user', [
            'name' => 'Test User',
            'email' => 'very-long-email-address-test@example.com',
            'zip_code' => '123-4567',
            'address' => 'Tokyo Test',
            'birth_date' => '1990-01-01',
            'tel_no' => '080-1234-5678',
            'image_url' => '/images/user/test.png',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_user_update_validation_fails_with_invalid_date(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/update_user', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'zip_code' => '123-4567',
            'address' => 'Tokyo Test',
            'birth_date' => 'invalid-date',
            'tel_no' => '080-1234-5678',
            'image_url' => '/images/user/test.png',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['birth_date']);
    }

    public function test_user_update_validation_fails_without_zip_code(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/update_user', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'address' => 'Tokyo Test',
            'birth_date' => '1990-01-01',
            'tel_no' => '080-1234-5678',
            'image_url' => '/images/user/test.png',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['zip_code']);
    }

    public function test_user_update_validation_fails_without_image_url(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/update_user', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'zip_code' => '123-4567',
            'address' => 'Tokyo Test',
            'birth_date' => '1990-01-01',
            'tel_no' => '080-1234-5678',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image_url']);
    }

    public function test_user_update_validation_passes_with_valid_json_user_field(): void
    {
        $this->createAuthenticatedUser();

        $userData = json_encode([
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'zip_code' => '999-9999',
            'address' => 'Updated Address',
            'birth_date' => '1995-05-15',
            'tel_no' => '090-9999-8888',
            'image_url' => '/images/user/new.png',
        ]);

        $response = $this->postJson('/api/update_user', [
            'user' => $userData,
            'password' => 'password123',
        ]);

        // Should pass validation (the service call may still fail or succeed)
        $response->assertStatus(200);
    }
}
