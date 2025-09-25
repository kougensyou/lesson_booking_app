<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LessonBooking\FirstBookingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Services\LessonBookingService;

class LessonBookingController extends Controller
{

    public function __construct() {
        $this->lessonBookingService = new LessonBookingService();
    }

    public function getSelectedLessonList(Request $request) {
        $userId = Auth::id();
        $selectedYear = $request->query('selected_year');
        $selectedMonth = $request->query('selected_month') + 1;
        return $this->lessonBookingService->getSelectedLessonList($userId, $selectedYear, $selectedMonth);
    }

    public function bookLesson(Request $request) {
        $lessonId = $request->input('lesson_id');
        $this->lessonBookingService->bookLesson($lessonId);

        return [
            'success' => true,
            'message' => 'The lesson was booked successfully.'
        ];
    }

    public function cancelLesson(Request $request) {
        $userId = Auth::id();
        $lessonId = $request->input('lesson_id');
        $this->lessonBookingService->cancelLesson($userId, $lessonId);

        return [
            'success' => true,
            'message' => 'The lesson was canceled successfully.'
        ];
    }

    public function addBookingHistory(Request $request) {
        $userId = Auth::id();
        return $this->lessonBookingService->addBookingHistory($userId);
    }

    public function validateFirstLesson(FirstBookingRequest $request) {
        return response()->json([
            'message' => 'Validation passed',
            'data'    => $request->validated(),
        ], 200);
    }

    public function applyFirstLesson(Request $request) {
        $firstBooking = $request->input('first_booking');
        $this->lessonBookingService->applyFirstLesson($firstBooking);

        return [
            'success' => true,
            'message' => 'The lesson was applied successfully.'
        ];
    }

}