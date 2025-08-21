<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function getBookingHistory(Request $request) {
        $userId = Auth::id();
        return $this->lessonBookingService->getBookingHistory($userId);
    }

}