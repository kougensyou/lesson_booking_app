<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Services\LessonCalendarService;

class LessonCalendarController extends Controller
{

    public function __construct() {
        $this->lessonCalendarService = new LessonCalendarService();
    }

    public function getSelectedLessonList(Request $request) {
        $userId = Auth::id();
        $selectedYear = $request->query('selected_year');
        $selectedMonth = $request->query('selected_month') + 1;
        return $this->lessonCalendarService->getSelectedLessonList($userId, $selectedYear, $selectedMonth);
    }

}