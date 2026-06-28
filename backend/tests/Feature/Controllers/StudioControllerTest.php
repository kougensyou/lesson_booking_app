<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StudioControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_studio_list_returns_200(): void
    {
        DB::table('studio')->insert([
            [
                'studio_name' => 'Studio A',
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'studio_name' => 'Studio B',
                'image_path' => '/images/studio/b.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->getJson('/api/get_studio_list');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'studio_name', 'image_url'],
        ]);
    }

    public function test_get_favorite_studio_list_returns_200(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Favorite User',
            'email' => 'fav-user@example.com',
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
            'studio_name' => 'Favorite Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('favorite_studio')->insert([
            'user_id' => $userId,
            'studio_id' => $studioId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = \App\Models\User::find($userId);
        $response = $this->actingAs($user)->getJson('/api/get_favorite_studio_list');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'studio_name', 'image_url'],
        ]);
    }

    public function test_get_favorite_studio_list_requires_auth(): void
    {
        $response = $this->getJson('/api/get_favorite_studio_list');

        $response->assertStatus(401);
    }

    public function test_save_favorite_studio_list_returns_200(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Save Fav User',
            'email' => 'save-fav@example.com',
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
            'studio_name' => 'Save Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = \App\Models\User::find($userId);
        $response = $this->actingAs($user)->postJson('/api/save_favorite_studio_list', [
            'initial_favorite_studio_list' => [],
            'favorite_studio_list' => [['id' => $studioId]],
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'studio_name', 'image_url'],
        ]);
    }
}
