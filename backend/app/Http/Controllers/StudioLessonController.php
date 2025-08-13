<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Services\StudioLessonService;

class StudioLessonController extends Controller
{

    public function __construct() {
        $this->studioLessonService = new StudioLessonService();
    }

    public function getStudioLessonData(Request $request) {
        return $this->studioLessonService->getStudioLessonData(Auth::id());
    }

}