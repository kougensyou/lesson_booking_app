<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\ReportRepository;

class ReportService
{

    public function __construct()
    {
        $this->reportRepository = new ReportRepository();
    }

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

        $insertData = [
            'user_id' => $userId,
            'title' => $title,
            'email' => $email,
            'contents' => $contents,
        ];

        try {

            $this->reportRepository->createReport($insertData);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}