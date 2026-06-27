<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Services\LessonService;

class LessonController extends Controller
{
    private LessonService $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    /**
     * Get the next lesson data for a given user
     * 
     * @param Request $request
     * @return array
     * 
     * @throws \Throwable
     */
    public function getNextLessonData(Request $request): array
    {
        try {
            $userId = Auth::id();
            return $this->lessonService->getNextLessonData($userId);
        } catch (\Throwable $e) {
            \Log::error('getNextLessonData error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Add a list of lessons from the same studio
     * 
     * @param Request $request
     * @return LengthAwarePaginator
     * 
     * @throws \Throwable
     */
    public function addSameStudioLessonList(Request $request): LengthAwarePaginator
    {
        try {
            $studioId = $request->query('studio_id');
            return $this->lessonService->addSameStudioLessonList($studioId);
        } catch (\Throwable $e) {
            \Log::error('addSameStudioLessonList error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get a list of lesson categories
     * 
     * @param Request $request
     * @return Collection
     * 
     * @throws \Throwable
     */
    public function getLessonCategorylist(Request $request): Collection
    {
        try {
            return $this->lessonService->getLessonCategorylist();
        } catch (\Throwable $e) {
            \Log::error('getLessonCategoryList error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get a list of time options
     * 
     * @param Request $request
     * @return array
     */
    public function getTimeOptions(Request $request): array
    {
        return $this->lessonService->getTimeOptions();
    }

    /**
     * Add searched lessons based on the search input form
     * 
     * @param Request $request
     * @return LengthAwarePaginator
     * 
     * @throws \Throwable
     */
    public function addSearchedLessons(Request $request): LengthAwarePaginator
    {
        try {
            $searchInputForm = json_decode($request->query('search_input_form'), true);
            return $this->lessonService->addSearchedLessons($searchInputForm);
        } catch (\Throwable $e) {
            \Log::error('addSearchedLessons error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get lesson detail for a given lesson
     * 
     * @param Request $request
     * @return object
     * 
     * @throws \Throwable
     */
    public function getLessonDetail(Request $request): object
    {
        try {
            $userId = Auth::id();
            $lessonId = $request->query('lesson_id');
            return $this->lessonService->getLessonDetail($userId, $lessonId);
        } catch (\Throwable $e) {
            \Log::error('getLessonDetail error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get studio lesson data for a given studio and date range
     * 
     * @param Request $request
     * @return array
     * 
     * @throws \Throwable
     */
    public function getStudioLessonData(Request $request): array
    {
        try {
            $studioId = $request->query('studio_id');
            $fromDate = $request->query('from_date');
            $toDate = $request->query('to_date');
            return $this->lessonService->getStudioLessonData($studioId, $fromDate, $toDate);
        } catch (\Throwable $e) {
            \Log::error('getStudioLessonData error: ' . $e->getMessage());
            throw $e;
        }
    }

}
