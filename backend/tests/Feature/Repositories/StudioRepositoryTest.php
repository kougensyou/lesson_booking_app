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

    public function test_get_studio_list_returns_studios_with_image_url(): void
    {
        $studioId = DB::table('studio')->insertGetId([
            'studio_name' => 'Image Studio',
            'image_path' => '/images/studio/img.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $noImageStudioId = DB::table('studio')->insertGetId([
            'studio_name' => 'No Image Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $result = (new StudioRepository())->getStudioList();

        $this->assertGreaterThanOrEqual(2, $result->count());

        $studio = $result->firstWhere('id', $studioId);
        $this->assertSame('Image Studio', $studio->studio_name);
        $this->assertSame('/storage/images/studio/img.png', $studio->image_url);

        $noImageStudio = $result->firstWhere('id', $noImageStudioId);
        $this->assertSame('No Image Studio', $noImageStudio->studio_name);
        $this->assertNull($noImageStudio->image_url);
    }

    public function test_add_favorite_studio_creates_record_in_database(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Favorite Tester',
            'email' => 'favorite-tester@example.com',
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

        (new StudioRepository())->addFavoriteStudio($userId, $studioId);

        $record = DB::table('favorite_studio')
            ->where('user_id', $userId)
            ->where('studio_id', $studioId)
            ->first();

        $this->assertNotNull($record);
        $this->assertSame($userId, $record->user_id);
        $this->assertSame($studioId, $record->studio_id);
    }

    public function test_delete_favorite_studios_removes_only_specified_records(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Delete Tester',
            'email' => 'delete-tester@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $studioId1 = DB::table('studio')->insertGetId([
            'studio_name' => 'Delete Target Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $studioId2 = DB::table('studio')->insertGetId([
            'studio_name' => 'Keep Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('favorite_studio')->insert([
            [
                'user_id' => $userId,
                'studio_id' => $studioId1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'studio_id' => $studioId2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        (new StudioRepository())->deleteFavoriteStudios($userId, [$studioId1]);

        $remainingRecords = DB::table('favorite_studio')
            ->where('user_id', $userId)
            ->get();

        $this->assertCount(1, $remainingRecords);
        $this->assertSame($studioId2, $remainingRecords->first()->studio_id);
    }

    public function test_delete_favorite_studios_does_not_affect_other_users(): void
    {
        $targetUserId = DB::table('user')->insertGetId([
            'name' => 'Target User',
            'email' => 'target-delete@example.com',
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
            'email' => 'other-delete@example.com',
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
            'studio_name' => 'Shared Studio',
            'image_path' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('favorite_studio')->insert([
            [
                'user_id' => $targetUserId,
                'studio_id' => $studioId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $otherUserId,
                'studio_id' => $studioId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        (new StudioRepository())->deleteFavoriteStudios($targetUserId, [$studioId]);

        $otherUserRecords = DB::table('favorite_studio')
            ->where('user_id', $otherUserId)
            ->get();

        $this->assertCount(1, $otherUserRecords);
    }
}
