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

    /**
     * Get the next lesson data for a given user
     * 
     * @param Request $request
     * @return mixed
     */
    public function getNextLessonData(Request $request) {
        $userId = Auth::id();
        return $this->lessonService->getNextLessonData($userId);
    }

    /**
     * Add a list of lessons from the same studio
     * 
     * @param Request $request
     * @return mixed
     */
    public function addSameStudioLessonList(Request $request) {
        $studioId = $request->query('studio_id');
        return $this->lessonService->addSameStudioLessonList($studioId);
    }

    /**
     * Get a list of lesson categories
     * 
     * @param Request $request
     * @return mixed
     */
    public function getLessonCategorylist(Request $request) {
        return $this->lessonService->getLessonCategorylist();
    }

    /**
     * Get a list of time options
     * 
     * @param Request $request
     * @return mixed
     */
    public function getTimeOptions(Request $request) {
        return $this->lessonService->getTimeOptions();
    }

    /**
     * Add searched lessons based on the search input form
     * 
     * @param Request $request
     * @return mixed
     */
    public function addSearchedLessons(Request $request) {
        $searchInputForm = json_decode($request->query('search_input_form'), true);
        return $this->lessonService->addSearchedLessons($searchInputForm);
    }

    /**
     * Get lesson detail for a given lesson
     * 
     * @param Request $request
     * @return mixed
     */
    public function getLessonDetail(Request $request) {
        $userId = Auth::id();
        $lessonId = $request->query('lesson_id');
        return $this->lessonService->getLessonDetail($userId, $lessonId);
    }

    /**
     * Get studio lesson data for a given studio and date range
     * 
     * @param Request $request
     * @return mixed
     */
    public function getStudioLessonData(Request $request) {
        $studioId = $request->query('studio_id');
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');
        return $this->lessonService->getStudioLessonData($studioId, $fromDate, $toDate);
    }

}