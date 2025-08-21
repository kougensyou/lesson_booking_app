<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\LessonBooking;
use App\Models\LessonCategory;
use App\Models\Studio;
use App\Models\FavoriteStudio;


class LessonBookingService
{

    public function getSelectedLessonList($userId, $selectedYear, $selectedMonth) {
        try{
            $startOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
            $endOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();
            return LessonBooking::select(
                'done_flag',
                'lesson.start_time',
            )
            ->join('lesson', 'lesson.id', '=', 'lesson_booking.lesson_id')
            ->whereBetween('lesson.start_time', [
                $startOfMonth,
                $endOfMonth
            ])
            ->where('lesson_booking.user_id', $userId)
            ->orderBy('lesson.start_time', 'asc')
            ->get();
        } catch (\Throwable $e) {
            \Log::error('getSelectedLessonList error: ' . $e->getMessage());
            throw $e;
        }
    }

    
    public function bookLesson($lessonId) {

        DB::beginTransaction();
        
        try {
            $insertData = [
                'booking_time' => Carbon::now(),
                'lesson_id' => $lessonId,
                'user_id' => Auth::id(),
                'done_flag' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            LessonBooking::insert($insertData);

            DB::commit();
            
        } catch (\Throwable $e) {
            \DB::rollback();
            \Log::error('bookLesson error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function cancelLesson($userId, $lessonId) {
        DB::beginTransaction();

        try {
            
            LessonBooking::where('user_id', $userId)
                ->where('lesson_id', $lessonId)
                ->delete();

            DB::commit();
            
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('deleteLessonBooking error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getBookingHistory($userId) {
        try {
            return LessonBooking::select(
                'lesson.id',
                'studio.studio_name as studio_name',
                'lesson.name as lesson_name',
                'lesson.start_time',
                'lesson.end_time',
                'instructor.name as instructor_name',
                'instructor.image_path'
            )
            ->join('lesson', 'lesson.id', '=', 'lesson_booking.lesson_id')
            ->join('studio', 'studio.id', '=', 'lesson.studio_id')
            ->join('instructor', 'instructor.id', '=', 'lesson.instructor_id')
            ->where('lesson_booking.user_id', $userId)
            ->where('lesson_booking.done_flag', config('const.lessonBooking.lessonDone'))
            ->orderBy('lesson.start_time', 'asc')
            ->paginate(config('const.lessonBooking.pagination'))
            ->through(function ($item) {
                $start = Carbon::parse($item->start_time);
                $end = Carbon::parse($item->end_time);
                $item->lesson_time = $start->format('n/j G:i') . ' - ' . $end->format('G:i');
                if ($item->image_path) {
                    $item->image_url = asset('storage/' . ltrim($item->image_path, '/'));
                    return $item;
                }
                $item->image_url = null;
                return $item;
            });
        } catch (\Throwable $e) {
            \Log::error('getLessonData error: ' . $e->getMessage());
            throw $e;
        }
    }


}