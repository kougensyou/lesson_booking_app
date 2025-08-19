<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Services\LessonDetailService;

class LessonDetailController extends Controller
{

    public function __construct() {
        $this->lessonDetailService = new LessonDetailService();
    }

    public function getLessonDetail(Request $request) {
        $userId = Auth::id();
        $lessonId = $request->query('lesson_id');
        return $this->lessonDetailService->getLessonDetail($userId, $lessonId);
    }

    public function bookLesson(Request $request) {
        $lessonId = $request->input('lesson_id');
        $this->lessonDetailService->bookLesson($lessonId);

        return [
            'success' => true,
            'message' => 'The lesson was booked successfully.'
        ];
    }

}