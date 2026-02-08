<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Report;

class ReportRepository
{
    /**
     * Send a report from the user
     * 
     * @param array $insertData Data for the new report
     * 
     * @throws \Throwable
     */
    public function createReport($insertData): void
    {
        Report::create($insertData);
    }
}