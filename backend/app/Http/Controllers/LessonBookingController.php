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

    public function getLessonBookingData(Request $request) {
        $userId = Auth::id();
        return $this->lessonBookingService->getLessonBookingData($userId);
    }

}