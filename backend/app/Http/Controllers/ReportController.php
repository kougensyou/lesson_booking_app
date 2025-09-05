<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Services\ReportService;

class ReportController extends Controller
{

    public function __construct() {
        $this->reportService = new ReportService();
    }

    public function sendReport(Request $request) {
        $userId = Auth::id();
        $title = $request->input('title');
        $email = $request->input('email');
        $contents = $request->input('contents');
        return $this->reportService->sendReport($userId, $title, $email, $contents);
    }

}