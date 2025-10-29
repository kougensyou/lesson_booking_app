<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Report;

class ReportService
{
    /**
     * Send a report from the user
     * 
     * @param int $userId
     * @param string $title
     * @param string $email
     * @param string $contents
     * @throws \Throwable
     * @return void
     */
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