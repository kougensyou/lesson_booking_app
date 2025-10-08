<?php
namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report;

class ReportService
{
    public function sendReport($userId, $title, $email, $contents) {
        
        DB::beginTransaction();

        try {
            Report::create([
                'user_id' => $userId,
                'title' => $title,
                'email' => $email,
                'contents' => $contents,
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('sendReport error: ' . $e->getMessage());
            throw $e;
        }
    }
}