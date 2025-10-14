<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;
use Carbon\Carbon;

class ReportSeeder extends Seeder
{
    public function run()
    {
        Report::insert([
            [
                'user_id' => 1,
                'title' => 'Report 1',
                'email' => 'user1@example.com',
                'contents' => 'Contents of report 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Report 2',
                'email' => 'user2@example.com',
                'contents' => 'Contents of report 2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'title' => 'Report 3',
                'email' => 'user3@example.com',
                'contents' => 'Contents of report 3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}