<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Studio;
use App\Models\FavoriteStudio;

class StudioRepository
{
    
    /**
     * Get a list of studios from the database
     *
     * @return Collection
     */
    public function getStudioList(): Collection
    {
        return Studio::select('id', 'studio_name', 'image_path')
        ->get()
        ->map(function ($item) {
            if ($item->image_path) {
                $item->image_url = '/storage/' . ltrim($item->image_path, '/');
                return $item;
            }
            $item->image_url = null;
            return $item;
        });
    }

    /**
     * Get a list of favorite studios for the user
     * 
     * @param int $userId User ID
     * @return Collection Favorite studio list
     */
    public function getFavoriteStudioList($userId): Collection
    {
        return FavoriteStudio::with('studio')
            ->where('user_id', $userId)
            ->get()
            ->map(function ($item) {
                $studio = $item->studio;

                return [
                    'id' => $studio->id,
                    'studio_name' => $studio->studio_name,
                    'short_studio_name' => mb_strimwidth(
                        $studio->studio_name,
                        0,
                        config('const.studio.shortStudioNameChar'),
                        ' ...'
                    ),
                    'image_url' => $studio->image_path ? '/storage/' . ltrim($studio->image_path, '/') : null,
                ];
            });
    }

    /**
     * Delete a list of favorite studios for the user
     *
     * @param int $userId User ID
     * @param array $studioIds Studio IDs to delete
     * @return void
     */
    public function deleteFavoriteStudios($userId, $studioIds): void
    {
        FavoriteStudio::where('user_id', $userId)
            ->whereIn('studio_id', $studioIds)
            ->delete();
    }

    /**
     * Add a favorite studio for the user
     *
     * @param int $userId User ID
     * @param int $studioId Studio ID to add
     * @return void
     */
    public function addFavoriteStudio($userId, $studioId): void
    {
        FavoriteStudio::create([
            'user_id'   => $userId,
            'studio_id' => $studioId,
        ]);
    }
    
}