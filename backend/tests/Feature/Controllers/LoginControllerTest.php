<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_with_valid_credentials_returns_200(): void
    {
        DB::table('user')->insert([
            'name' => 'Login Test User',
            'email' => 'login-test@example.com',
            'password' => bcrypt('correct-password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->withSession([])->withHeaders(['Accept' => 'application/json'])->post('/api/login', [
            'email' => 'login-test@example.com',
            'password' => 'correct-password',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Login successful',
        ]);
    }

    public function test_login_with_invalid_credentials_returns_401(): void
    {
        DB::table('user')->insert([
            'name' => 'Login Test User',
            'email' => 'login-test@example.com',
            'password' => bcrypt('correct-password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->withSession([])->withHeaders(['Accept' => 'application/json'])->post('/api/login', [
            'email' => 'login-test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Invalid credentials',
        ]);
    }

    public function test_logout_returns_200(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Logout Test User',
            'email' => 'logout-test@example.com',
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

        $response = $this->actingAs($user)->withSession([])->withHeaders(['Accept' => 'application/json'])->post('/api/logout');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Logged out successfully',
        ]);
    }

    public function test_logout_without_auth_returns_200(): void
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Already Unauthenticated.',
        ]);
    }
}
