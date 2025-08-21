<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Services\LessonService;

class LessonController extends Controller
{

    public function __construct() {
        $this->lessonService = new LessonService();
    }

    public function getNextLessonData(Request $request) {
        $userId = Auth::id();
        return $this->lessonService->getNextLessonData($userId);
    }

    public function getSameStudioLessonList(Request $request) {
        $studioId = $request->query('studio_id');
        return $this->lessonService->getSameStudioLessonList($studioId);
    }

    public function getSearchInputData(Request $request) {
        $userId = Auth::id();
        return $this->lessonService->getSearchInputData($userId);
    }

    public function searchLessons(Request $request) {
        $searchInputForm = $request->input('searchInputForm');
        return $this->lessonService->searchLessons($searchInputForm);
    }

}