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
    public function getHomeData($userId, $selectedYear, $selectedMonth) {
        try {
            $nextLessonList = $this->getNextLessonList($userId);
            $lessonListThisMonth = $this->getSelectedLessonList($userId, $selectedYear, $selectedMonth);
            $infoList = $this->getInfoList();

            return [
                'next_lesson_list' => $nextLessonList,
                'selected_lesson_list' => $lessonListThisMonth,
                'info_list' => $infoList,
            ];
        } catch (\Throwable $e) {
            \Log::error('getHomeData error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getNextLessonList($userId) {
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
            if ($item->image_path) {
                $item->image_url = asset('storage/' . ltrim($item->image_path, '/'));
                return $item;
            }
            $item->image_url = null;
            return $item;
        });
    }

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

    private function getInfoList() {
        $sliderInfo = Info::where('kind', config('const.home.infoKindSlider'))
        ->where('visible_flag', true)
        ->orderBy('sort_order', 'asc')
        ->get()
        ->map(function ($item) {
            if ($item->image_path) {
                $item->image_url = asset('storage/' . ltrim($item->image_path, '/'));
                return $item;
            }
            $item->image_url = null;
            return $item;
        });
        $gridInfo = Info::where('kind', config('const.home.infoKindGrid'))
        ->where('visible_flag', true)
        ->orderBy('sort_order', 'asc')
        ->get()
        ->map(function ($item) {
            if ($item->image_path) {
                $item->image_url = asset('storage/' . ltrim($item->image_path, '/'));
                return $item;
            }
            $item->image_url = null;
            return $item;
        });
        $listInfo = Info::where('kind', config('const.home.infoKindList'))
        ->where('visible_flag', true)
        ->orderBy('sort_order', 'asc')
        ->get();
        return [
            'slider_info' => $sliderInfo,
            'grid_info'   => $gridInfo,
            'list_info'   => $listInfo,
        ];
    }

}