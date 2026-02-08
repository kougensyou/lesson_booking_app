<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LessonBooking\FirstBookingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\LessonBookingService;

class LessonBookingController extends Controller
{

    public function __construct()
    {
        $this->lessonBookingService = new LessonBookingService();
    }

    /**
     * Get a list of lessons for a given user and selected date
     * 
     * @param Request $request
     * @return Collection
     * 
     * @throws \Throwable
     */
    public function getSelectedLessonList(Request $request): Collection
    {
        try {
            $userId = Auth::id();
            $selectedYear = $request->query('selected_year');
            $selectedMonth = $request->query('selected_month') + 1;
            return $this->lessonBookingService->getSelectedLessonList($userId, $selectedYear, $selectedMonth);
        } catch (\Throwable $e) {
            \Log::error('getSelectedLessonList error: ' . $e->getMessage());
            throw $e;
        }
    }


    /**
     * Book a lesson for a given user
     * 
     * @param Request $request
     * @return array
     * 
     * @throws \Throwable
     */
    public function bookLesson(Request $request): array
    {
        try {
            $lessonId = $request->input('lesson_id');
            $this->lessonBookingService->bookLesson($lessonId);
            return [
                'success' => true,
                'message' => 'The lesson was booked successfully.'
            ];
        } catch (\Throwable $e) {
            \Log::error('bookLesson error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cancel a lesson for a given user
     * 
     * @param Request $request
     * @return array
     * 
     * @throws \Throwable
     */
    public function cancelLesson(Request $request): array
    {
        try {
            $userId = Auth::id();
            $lessonId = $request->input('lesson_id');
            $this->lessonBookingService->cancelLesson($userId, $lessonId);
            return [
                'success' => true,
                'message' => 'The lesson was canceled successfully.'
            ];
        } catch (\Throwable $e) {
            \Log::error('cancelLesson error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Add a booking history for a given user
     *
     * @param Request $request
     * @return LengthAwarePaginator
     * 
     * @throws \Throwable
     */     
    public function addBookingHistory(Request $request): LengthAwarePaginator
    {
        try {
            $userId = Auth::id();
            return $this->lessonBookingService->addBookingHistory($userId);
        } catch (\Throwable $e) {
            \Log::error('addBookingHistory error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Validate the first lesson booking request
     * 
     * @param FirstBookingRequest $request
     * @return JsonResponse
     */
    public function validateFirstLesson(FirstBookingRequest $request): JsonResponse
    {
        return response()->json([
            'message' => 'Validation passed',
            'data'    => $request->validated(),
        ], 200);
    }

    /**
     * Apply the first lesson booking
     * 
     * @param FirstBookingRequest $request
     * @return array
     * 
     * @throws \Throwable
     */
    public function applyFirstLesson(FirstBookingRequest $request): array
    {
        try {
            $firstBooking = $request->input('first_booking');
            $this->lessonBookingService->applyFirstLesson($firstBooking);
            return [
                'success' => true,
                'message' => 'The first lesson was applied successfully.'
            ];
        } catch (\Throwable $e) {
            \Log::error('applyFirstLesson error: ' . $e->getMessage());
            throw $e;
        }
    }

}