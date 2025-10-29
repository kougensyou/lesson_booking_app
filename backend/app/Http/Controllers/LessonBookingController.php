<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LessonBooking\FirstBookingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Services\LessonBookingService;

class LessonBookingController extends Controller
{

    public function __construct() {
        $this->lessonBookingService = new LessonBookingService();
    }

    /**
     * Get a list of lessons for a given user and selected date
     * 
     * @param Request $request
     * @return mixed
     */
    public function getSelectedLessonList(Request $request) {
        $userId = Auth::id();
        $selectedYear = $request->query('selected_year');
        $selectedMonth = $request->query('selected_month') + 1;
        return $this->lessonBookingService->getSelectedLessonList($userId, $selectedYear, $selectedMonth);
    }


    /**
     * Book a lesson for a given user
     * 
     * @param Request $request
     * @return array
     */
    public function bookLesson(Request $request) {
        $lessonId = $request->input('lesson_id');
        $this->lessonBookingService->bookLesson($lessonId);

        return [
            'success' => true,
            'message' => 'The lesson was booked successfully.'
        ];
    }

    /**
     * Cancel a lesson for a given user
     * 
     * @param Request $request
     * @return array
     */
    public function cancelLesson(Request $request) {
        $userId = Auth::id();
        $lessonId = $request->input('lesson_id');
        $this->lessonBookingService->cancelLesson($userId, $lessonId);

        return [
            'success' => true,
            'message' => 'The lesson was canceled successfully.'
        ];
    }

    /**
     * Add a booking history for a given user
     *
     * @param Request $request
     * @return mixed
     */     
    public function addBookingHistory(Request $request) {
        $userId = Auth::id();
        return $this->lessonBookingService->addBookingHistory($userId);
    }

    /**
     * Validate the first lesson booking request
     * 
     * @param FirstBookingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateFirstLesson(FirstBookingRequest $request) {
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
     */
    public function applyFirstLesson(FirstBookingRequest $request) {
        $firstBooking = $request->input('first_booking');
        $this->lessonBookingService->applyFirstLesson($firstBooking);

        return [
            'success' => true,
            'message' => 'The lesson was applied successfully.'
        ];
    }

}