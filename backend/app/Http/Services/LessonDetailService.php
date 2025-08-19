<?php
namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CustomErrorResponseException;
use App\Models\Lesson;
use App\Models\LessonBooking;

class LessonDetailService
{
    public function getLessonDetail($userId, $lessonId) {
        try {
            return Lesson::select(
                'studio.id as studio_id',
                'studio.studio_name as studio_name',
                'lesson.name as lesson_name',
                'lesson.explanation as lesson_explanation',
                'lesson.image_path as lesson_image_path',
                'lesson.start_time',
                'lesson.end_time',
                'instructor.name as instructor_name',
                'instructor.introduction as instructor_introduction',
                'instructor.image_path as instructor_image_path',
                \DB::raw('CASE WHEN lesson_booking.id IS NOT NULL THEN true ELSE false END as reserved_flag')
            )
            ->join('studio', 'studio.id', '=', 'lesson.studio_id')
            ->join('instructor', 'instructor.id', '=', 'lesson.instructor_id')
            ->leftJoin('lesson_booking', function ($join) use ($userId) {
                $join->on('lesson_booking.lesson_id', '=', 'lesson.id')
                    ->where('lesson_booking.user_id', '=', $userId);
            })
            ->where('lesson.id', $lessonId)
            ->get()
            ->map(function ($item) {
                $start = Carbon::parse($item->start_time);
                $end = Carbon::parse($item->end_time);
                $item->lesson_day = $start->format('n/j');
                $item->lesson_time = $start->format('G:i') . ' - ' . $end->format('G:i');
                $item->lesson_datetime = $item->lesson_day . ' ' . $item->lesson_time;
                $item->lesson_image_url = $item->lesson_image_path ? asset('storage/' . ltrim($item->lesson_image_path, '/')) : null;
                $item->instructor_image_url = $item->instructor_image_path ? asset('storage/' . ltrim($item->instructor_image_path, '/')) : null;
                $item->reserved_flag = (bool) $item->reserved_flag;
                return $item;
            })
            ->first();

        } catch (\Throwable $e) {
            \Log::error('getLessonDetail error: ' . $e->getMessage());
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

}