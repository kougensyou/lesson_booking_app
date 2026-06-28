<?php

namespace Tests\Feature\Repositories;

use App\Repositories\StudioRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StudioRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_favorite_studio_list_returns_only_target_user_studios(): void
    {
        config(['const.studio.shortStudioNameChar' => 10]);

        $targetUserId = DB::table('user')->insertGetId([
            'name' => 'Target User',
            'email' => 'target-user@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $otherUserId = DB::table('user')->insertGetId([
            'name' => 'Other User',
            'email' => 'other-user@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $targetStudioId = DB::table('studio')->insertGetId([
            'studio_name' => 'Target Studio',
            'image_path' => '/images/studio/target.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $otherStudioId = DB::table('studio')->insertGetId([
            'studio_name' => 'Other Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('favorite_studio')->insert([
            [
                'user_id' => $targetUserId,
                'studio_id' => $targetStudioId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $otherUserId,
                'studio_id' => $otherStudioId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $result = (new StudioRepository())->getFavoriteStudioList($targetUserId);

        $this->assertCount(1, $result);
        $this->assertSame($targetStudioId, $result[0]['id']);
        $this->assertSame('Target Studio', $result[0]['studio_name']);
        $this->assertSame('/storage/images/studio/target.png', $result[0]['image_url']);
    }
}
