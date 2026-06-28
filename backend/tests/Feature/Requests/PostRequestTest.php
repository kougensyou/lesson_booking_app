<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostRequestTest extends TestCase
{
    use DatabaseTransactions;

    private function createAuthenticatedUser(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Report Auth User',
            'email' => 'report-auth@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = \App\Models\User::find($userId);
        $this->actingAs($user);
    }

    public function test_report_validation_fails_without_title(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/send_report', [
            'email' => 'report@example.com',
            'contents' => 'Test report contents.',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);
    }

    public function test_report_validation_fails_with_long_title(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/send_report', [
            'title' => str_repeat('あ', 51),
            'email' => 'report@example.com',
            'contents' => 'Test report contents.',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);
    }

    public function test_report_validation_fails_without_email(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/send_report', [
            'title' => 'Test Report',
            'contents' => 'Test report contents.',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_report_validation_fails_with_invalid_email(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/send_report', [
            'title' => 'Test Report',
            'email' => 'not-an-email',
            'contents' => 'Test report contents.',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_report_validation_fails_with_long_email(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/send_report', [
            'title' => 'Test Report',
            'email' => 'very-long-email-address@example.com',
            'contents' => 'Test report contents.',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_report_validation_fails_without_contents(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/send_report', [
            'title' => 'Test Report',
            'email' => 'report@example.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['contents']);
    }

    public function test_report_validation_fails_without_auth(): void
    {
        $response = $this->postJson('/api/send_report', [
            'title' => 'Test Report',
            'email' => 'report@example.com',
            'contents' => 'Test report contents.',
        ]);

        $response->assertStatus(401);
    }

    public function test_report_validation_passes_with_valid_data(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson('/api/send_report', [
            'title' => 'Test Report',
            'email' => 'report@example.com',
            'contents' => 'Test report contents.',
        ]);

        // Should pass validation (the service call may still fail or succeed)
        $this->assertNotEquals(422, $response->status());
    }
}
