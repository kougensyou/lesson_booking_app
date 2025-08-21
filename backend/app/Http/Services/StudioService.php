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
}