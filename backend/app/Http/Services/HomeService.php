<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\LessonBooking;
use App\Models\Instructor;
use App\Models\Info;
use App\Models\Studio;


class HomeService
{
    public function getHomeData() {
        try {
            $userId = Auth::id();
            $nextLessonList = $this->getNextLessonList($userId);
            $lessonListThisMonth = $this->getLessonListThisMonth($userId);
            $infoList = $this->getInfoList();

            return [
                'next_lesson_list' => $nextLessonList,
                'lesson_list_this_month' => $lessonListThisMonth,
                'info_list' => $infoList,
            ];
        } catch (\Throwable $e) {
            \Log::error('getHomeData error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getNextLessonList($userId) {
        return LessonBooking::select(
            'done_flag',
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
        ->where('lesson.start_time', '>', Carbon::now())
        ->where('lesson_booking.user_id', $userId)
        ->whereNull('lesson_booking.done_flag')
        ->orderBy('lesson.start_time', 'asc')
        ->take(5)
        ->get()
        ->map(function ($item) {
            $start = Carbon::parse($item->start_time);
            $end = Carbon::parse($item->end_time);
            $item->lesson_time = $start->format('n/j G:i') . ' - ' . $end->format('G:i');
            return $item;
        });
    }

    private function getLessonListThisMonth($userId) {
        return LessonBooking::select(
            'done_flag',
            'lesson.start_time',
        )
        ->join('lesson', 'lesson.id', '=', 'lesson_booking.lesson_id')
        ->whereBetween('lesson.start_time', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])
        ->where('lesson_booking.user_id', $userId)
        ->orderBy('lesson.start_time', 'asc')
        ->get();
    }

    private function getInfoList() {
        return [
            'slider_info' => Info::where('kind', 1)->get(),
            'grid_info'   => Info::where('kind', 2)->get(),
        ];
    }

}