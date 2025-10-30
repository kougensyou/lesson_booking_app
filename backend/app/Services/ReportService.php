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
     */
    public function sendReport($userId, $title, $email, $contents): void
    {
        
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
            throw $e;
        }
    }
}