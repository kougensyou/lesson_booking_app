<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class InformationControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_information_list_returns_200(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Info Test User',
            'email' => 'info-test@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert info records for each kind (1=slider, 2=grid, 3=list)
        DB::table('info')->insert([
            [
                'name' => 'Slider Info',
                'image_path' => null,
                'kind' => 1,
                'link_url' => null,
                'visible_flag' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grid Info',
                'image_path' => null,
                'kind' => 2,
                'link_url' => null,
                'visible_flag' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'List Info',
                'image_path' => null,
                'kind' => 3,
                'link_url' => null,
                'visible_flag' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $user = \App\Models\User::find($userId);
        $response = $this->actingAs($user)->getJson('/api/get_information_list');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'slider_info',
            'grid_info',
            'list_info',
        ]);
    }

    public function test_get_information_list_requires_auth(): void
    {
        $response = $this->getJson('/api/get_information_list');

        $response->assertStatus(401);
    }
}
