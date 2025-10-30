<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Studio;
use App\Models\FavoriteStudio;

class StudioService
{
    
    /**
     * Get a list of studios from the database
     *
     * @return array
     * @throws Throwable
     */
    public function getStudioList() {
        try {
            return Studio::select('id', 'studio_name', 'image_path')
            ->get()
            ->map(function ($item) {
                if ($item->image_path) {
                    $item->image_url = asset('storage/' . ltrim($item->image_path, '/'));
                    return $item;
                }
                $item->image_url = null;
                return $item;
            });
        } catch (\Throwable $e) {
            \Log::error('getStudioList error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get a list of favorite studios for the user
     * 
     * @param int $userId User ID
     * @return array Favorite studio list
     * @throws Throwable
     */
    public function getFavoriteStudioList($userId) {
        try {
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
                        'image_url' => $studio->image_path ? asset('storage/' . ltrim($studio->image_path, '/')) : null,
                    ];
                });
        } catch (\Throwable $e) {
            \Log::error('getFavoriteStudioList error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Save a list of favorite studios for the user
     *
     * @param int $userId User ID
     * @param array $initialFavoriteStudioList Initial favorite studio list
     * @param array $favoriteStudioList Favorite studio list
     * @return void
     * @throws Throwable
     */
    public function saveFavoriteStudioList($userId, $initialFavoriteStudioList, $favoriteStudioList) {

        DB::beginTransaction();

        try {
            $initialIds = collect($initialFavoriteStudioList)->pluck('id')->all();
            $currentIds = collect($favoriteStudioList)->pluck('id')->all();

            // Delete
            $toDelete = array_diff($initialIds, $currentIds);
            if (!empty($toDelete)) {
                FavoriteStudio::where('user_id', $userId)
                    ->whereIn('studio_id', $toDelete)
                    ->delete();
            }

            // Insert
            $toAdd = array_diff($currentIds, $initialIds);
            foreach ($toAdd as $studioId) {
                FavoriteStudio::create([
                    'user_id'   => $userId,
                    'studio_id' => $studioId,
                ]);
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('saveFavoriteStudioList error: ' . $e->getMessage());
            throw $e;
        }
    }
}