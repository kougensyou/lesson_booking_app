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

    public function addSameStudioLessonList(Request $request) {
        $studioId = $request->query('studio_id');
        return $this->lessonService->addSameStudioLessonList($studioId);
    }

    public function getLessonCategorylist(Request $request) {
        return $this->lessonService->getLessonCategorylist();
    }

    public function getTimeOptions(Request $request) {
        return $this->lessonService->getTimeOptions();
    }

    public function addSearchedLessons(Request $request) {
        $searchInputForm = json_decode($request->query('search_input_form'), true);
        return $this->lessonService->addSearchedLessons($searchInputForm);
    }

    public function getLessonDetail(Request $request) {
        $userId = Auth::id();
        $lessonId = $request->query('lesson_id');
        return $this->lessonService->getLessonDetail($userId, $lessonId);
    }

    public function getStudioLessonData(Request $request) {
        $studioId = $request->query('studio_id');
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');
        return $this->lessonService->getStudioLessonData($studioId, $fromDate, $toDate);
    }

}