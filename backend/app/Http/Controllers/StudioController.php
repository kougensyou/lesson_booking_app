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

    public function getStudioList(Request $request) {
        return $this->studioService->getStudioList();
    }

    public function getFavoriteStudioList(Request $request) {
        $userId = Auth::id();
        return $this->studioService->getFavoriteStudioList($userId);
    }

}