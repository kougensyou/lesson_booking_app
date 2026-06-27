<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\LessonBookingRepository;

class LessonBookingService
{
    private LessonBookingRepository $lessonBookingRepository;

    public function __construct(LessonBookingRepository $lessonBookingRepository)
    {
        $this->lessonBookingRepository = $lessonBookingRepository;
    }

    /**
     * Get a list of lessons for a given user and selected date
     * 
     * @param int $userId
     * @param int $selectedYear
     * @param int $selectedMonth
     * 
     * @return Collection
     */
    public function getSelectedLessonList($userId, $selectedYear, $selectedMonth): Collection
    {
        $startOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();
        return $this->lessonBookingRepository->getSelectedLessonList($userId, $startOfMonth, $endOfMonth);
    }

    /**
     * Book a lesson for the authenticated user
     * 
     * @param int $lessonId
     * 
     * @throws \Throwable
     */
    public function bookLesson($lessonId): void
    {

        DB::beginTransaction();
        
        try {

            $now = Carbon::now();

            $insertData = [
                'booking_time' => $now,
                'lesson_id' => $lessonId,
                'user_id' => Auth::id(),
                'done_flag' => null,
                'created_at' => $now,
                'updated_at' => $now
            ];

            $this->lessonBookingRepository->createLessonBooking($insertData);
            $this->lessonBookingRepository->incrementBookingUserNum($lessonId);

            DB::commit();
            
        } catch (\Throwable $e) {
            \DB::rollback();
            throw $e;
        }
    }

    /**
     * Cancel a lesson booking for a given user and lesson
     * 
     * @param int $userId User ID
     * @param int $lessonId Lesson ID
     * 
     * @throws \Throwable
     */
    public function cancelLesson($userId, $lessonId): void
    {

        DB::beginTransaction();

        try {

            $this->lessonBookingRepository->deleteLessonBooking($userId, $lessonId);
            $this->lessonBookingRepository->decrementBookingUserNum($lessonId);

            DB::commit();
            
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get a list of booking history for a given user
     * 
     * @param int $userId User ID
     * 
     * @return LengthAwarePaginator
     */
    public function addBookingHistory($userId): LengthAwarePaginator
    {
        return $this->lessonBookingRepository->addBookingHistory($userId);
    }

    /**
     * Apply the first lesson booking
     * 
     * @param array $firstBooking Request data for the first lesson booking
     */
    public function applyFirstLesson($firstBooking): void
    {
        $this->lessonBookingRepository->sendMail($firstBooking);
    }

}
