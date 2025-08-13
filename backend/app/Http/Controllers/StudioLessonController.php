<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Services\StudioLessonService;

class StudioLessonController extends Controller
{

    public function __construct() {
        $this->studioLessonService = new StudioLessonService();
    }

    public function getStudioLessonData(Request $request) {
        $studioId = $request->query('studio_id');
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');
        return $this->studioLessonService->getStudioLessonData($studioId, $fromDate, $toDate);
    }

}