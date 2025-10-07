<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use Illuminate\Support\Facades\DB;
use App\Models\Studio;
use App\Models\FavoriteStudio;


class StudioService
{
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

    public function getFavoriteStudioList($userId) {
        try {
            return FavoriteStudio::join('studio', 'studio.id', '=', 'favorite_studio.studio_id')
            ->where('favorite_studio.user_id', $userId)
            ->get()
            ->map(function ($item) {

                $item->short_studio_name = mb_strlen($item->studio_name) > 15
                    ? mb_substr($item->studio_name, 0, 15) . ' ...'
                    : $item->studio_name;

                if ($item->image_path) {
                    $item->image_url = asset('storage/' . ltrim($item->image_path, '/'));
                    return $item;
                }
                $item->image_url = null;
                return $item;
            });
        } catch (\Throwable $e) {
            \Log::error('getFavoriteStudioList error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function saveFavoriteStudioList($userId, $initialFavoriteStudioList, $favoriteStudioList) {
        DB::beginTransaction();

        try {
            $initialIds = collect($initialFavoriteStudioList)->pluck('id')->all();
            $currentIds = collect($favoriteStudioList)->pluck('id')->all();

            // 削除
            $toDelete = array_diff($initialIds, $currentIds);
            if (!empty($toDelete)) {
                FavoriteStudio::where('user_id', $userId)
                    ->whereIn('studio_id', $toDelete)
                    ->delete();
            }

            // 追加
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