<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

use App\Services\StudioService;

class StudioController extends Controller
{
    private StudioService $studioService;

    public function __construct(StudioService $studioService)
    {
        $this->studioService = $studioService;
    }

    /**
     * Get a list of studios from the database
     *
     * @param Request $request
     * @return Collection
     * 
     * @throws \Throwable
     */
    public function getStudioList(Request $request): Collection
    {
        try {
            return $this->studioService->getStudioList();
        } catch (\Throwable $e) {
            \Log::error('getStudioList error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get a list of favorite studios for the user
     *
     * @param Request $request
     * @return Collection
     * 
     * @throws \Throwable
     */
    public function getFavoriteStudioList(Request $request): Collection
    {
        try {
            $userId = Auth::id();
            return $this->studioService->getFavoriteStudioList($userId);
        } catch (\Throwable $e) {
            \Log::error('getFavoriteStudioList error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Save a list of favorite studios for the user
     *
     * @param Request $request
     * @return Collection
     * 
     * @throws \Throwable
     */
    public function saveFavoriteStudioList(Request $request): Collection
    {
        try {
            $userId = Auth::id();
            $initialFavoriteStudioList = $request->input('initial_favorite_studio_list');
            $favoriteStudioList = $request->input('favorite_studio_list');
            $this->studioService->saveFavoriteStudioList($userId, $initialFavoriteStudioList, $favoriteStudioList);
            return $this->studioService->getFavoriteStudioList($userId);
        } catch (\Throwable $e) {
            \Log::error('saveFavoriteStudioList error: ' . $e->getMessage());
            throw $e;
        }
    }

}
