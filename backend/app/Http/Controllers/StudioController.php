<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Services\StudioService;

class StudioController extends Controller
{

    public function __construct() {
        $this->studioService = new StudioService();
    }

    /**
     * Get a list of studios from the database
     *
     * @param Request $request
     * @return mixed
     */
    public function getStudioList(Request $request) {
        return $this->studioService->getStudioList();
    }

    /**
     * Get a list of favorite studios for the user
     *
     * @param Request $request
     * @return mixed
     */
    public function getFavoriteStudioList(Request $request) {
        $userId = Auth::id();
        return $this->studioService->getFavoriteStudioList($userId);
    }

    /**
     * Save a list of favorite studios for the user
     *
     * @param Request $request
     * @return mixed
     */
    public function saveFavoriteStudioList(Request $request) {
        $userId = Auth::id();
        $initialFavoriteStudioList = $request->input('initial_favorite_studio_list');
        $favoriteStudioList = $request->input('favorite_studio_list');
        $this->studioService->saveFavoriteStudioList($userId, $initialFavoriteStudioList, $favoriteStudioList);
        return $this->studioService->getFavoriteStudioList($userId);
    }

}