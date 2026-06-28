<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Carbon\Carbon;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_user_returns_200(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Controller User',
            'email' => 'ctrl-user@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => '/images/user/controller.png',
            'zip_code' => '123-4567',
            'tel_no' => '080-1234-5678',
            'address' => 'Tokyo Test 1-1-1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = \App\Models\User::find($userId);
        $response = $this->actingAs($user)->getJson('/api/user');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'zip_code',
            'address',
            'birth_date',
            'tel_no',
            'image_path',
            'image_url',
        ]);
        $response->assertJson([
            'name' => 'Controller User',
            'email' => 'ctrl-user@example.com',
        ]);
    }

    public function test_get_user_requires_auth(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }
}
