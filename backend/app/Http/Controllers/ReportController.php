<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Report\PostRequest;

use App\Services\ReportService;

class ReportController extends Controller
{
    private ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Send a report from the user
     * 
     * @param PostRequest $request
     * @return array
     * 
     * @throws \Throwable
     */
    public function sendReport(PostRequest $request): array
    {
        try {
            $userId = Auth::id();
            $title = $request->input('title');
            $email = $request->input('email');
            $contents = $request->input('contents');
            $this->reportService->sendReport($userId, $title, $email, $contents);
            return [
                'success' => true,
                'message' => 'The report was sent successfully.'
            ];
        } catch (\Throwable $e) {
            \Log::error('sendReport error: ' . $e->getMessage());
            throw $e;
        }
    }

}
