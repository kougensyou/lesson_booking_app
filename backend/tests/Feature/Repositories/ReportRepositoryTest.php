<?php

namespace Tests\Feature\Repositories;

use App\Repositories\ReportRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ReportRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_report_creates_record(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Report User',
            'email' => 'report-user@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $insertData = [
            'user_id' => $userId,
            'title' => 'Test Report Title',
            'email' => 'report-user@example.com',
            'contents' => 'This is a test report content for testing purposes.',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        (new ReportRepository())->createReport($insertData);

        $record = DB::table('report')
            ->where('user_id', $userId)
            ->first();

        $this->assertNotNull($record);
        $this->assertSame($userId, $record->user_id);
        $this->assertSame('Test Report Title', $record->title);
        $this->assertSame('This is a test report content for testing purposes.', $record->contents);
    }
}
