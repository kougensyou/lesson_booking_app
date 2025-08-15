<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\LessonDetailService;

class LessonDetailController extends Controller
{

    public function __construct() {
        $this->lessonDetailService = new LessonDetailService();
    }

    public function getLessonDetail(Request $request) {
        $lessonId = $request->query('lesson_id');
        return $this->lessonDetailService->getLessonDetail($lessonId);
    }

}