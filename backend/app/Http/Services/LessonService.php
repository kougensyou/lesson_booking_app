<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\LessonBooking;
use App\Models\LessonCategory;
use App\Models\Lesson;
use App\Models\Studio;

class LessonService
{
    public function getNextLessonData($userId) {
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
        } catch (\Throwable $e) {
            \Log::error('getLessonData error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getSameStudioLessonList($studioId) {
        try {

            return Lesson::select(
                'lesson.id',
                'studio.studio_name as studio_name',
                'lesson.name as lesson_name',
                'lesson.start_time',
                'lesson.end_time',
                'instructor.name as instructor_name',
                'instructor.image_path'
            )
            ->join('studio', 'studio.id', '=', 'lesson.studio_id')
            ->join('instructor', 'instructor.id', '=', 'lesson.instructor_id')
            ->where('lesson.start_time', '>', Carbon::now())
            ->where('lesson.studio_id', $studioId)
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

        } catch (\Throwable $e) {
            \Log::error('getLessonData error: ' . $e->getMessage());
            throw $e;
        }
        
    }

    public function getSearchInputData($userId) {
        try {
            $studioList = $this->getStudioList();
            $lessonCategoryList = $this->getLessonCategoryList();

            return [
                'studio_list' => $studioList,
                'lesson_category_list' => $lessonCategoryList,
                'start_time_options' => config('const.lesson.startTimeOptions'),
                'end_time_options' => config('const.lesson.endTimeOptions'),
            ];
        } catch (\Throwable $e) {
            \Log::error('getSearchInputData error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getStudioList() {
        return Studio::select('id', 'studio_name', 'image_path')
        ->get()
        ->map(function ($item) {
            if ($item->image_path) {
                $item->image_url = asset('storage/' . ltrim($item->image_path, '/'));
                return $item;
            }
            $item->image_url = null;
            return $item;
        });
    }

    private function getLessonCategoryList() {
        return LessonCategory::select('id', 'category_name')
        ->get();
    }

    public function searchLessons($searchInputForm) {
        try {
            return Lesson::select(
                    'lesson.id',
                    'studio.studio_name as studio_name',
                    'lesson.name as lesson_name',
                    'lesson.start_time',
                    'lesson.end_time',
                    'instructor.name as instructor_name',
                    'instructor.image_path'
                )
                ->join('studio', 'studio.id', '=', 'lesson.studio_id')
                ->join('instructor', 'instructor.id', '=', 'lesson.instructor_id')
                ->where('lesson.start_time', '>', Carbon::now())
                ->when(!empty($searchInputForm['selectedDates']), function($q) use ($searchInputForm) {
                    $q->where(function($q2) use ($searchInputForm) {
                        foreach ($searchInputForm['selectedDates'] as $date) {
                            $q2->orWhere('lesson.start_time', 'like', "%{$date}%");
                        }
                    });
                })
                ->when(!empty($searchInputForm['startTime']), function($q) use ($searchInputForm) {
                    $q->whereRaw("TO_CHAR(lesson.start_time, 'HH24:MI') > ?", [$searchInputForm['startTime']]);
                })
                ->when(!empty($searchInputForm['endTime']), function($q) use ($searchInputForm) {
                    $q->whereRaw("TO_CHAR(lesson.end_time, 'HH24:MI') < ?", [$searchInputForm['endTime']]);
                })
                ->when(!empty($searchInputForm['lessonCategory']), function($q) use ($searchInputForm) {
                    $q->where('lesson.lesson_category_id', $searchInputForm['lessonCategory']);
                })
                ->when(!empty($searchInputForm['studio']), function($q) use ($searchInputForm) {
                    $q->where('lesson.studio_id', $searchInputForm['studio']);
                })
                ->when(!empty($searchInputForm['instructor']), function($q) use ($searchInputForm) {
                    $q->where('instructor.name', 'like', "%{$searchInputForm['instructor']}%");
                })
                ->when(!empty($searchInputForm['lessonName']), function($q) use ($searchInputForm) {
                    $q->where('lesson.name', 'like', "%{$searchInputForm['lessonName']}%");
                })
                ->orderBy('lesson.start_time', 'asc')
                ->take(5)
                ->get()
                ->map(function ($item) {
                    $start = Carbon::parse($item->start_time);
                    $end = Carbon::parse($item->end_time);
                    $item->lesson_time = $start->format('n/j G:i') . ' - ' . $end->format('G:i');
                    $item->image_url = $item->image_path ? asset('storage/' . ltrim($item->image_path, '/')) : null;
                    return $item;
                });
        } catch (\Throwable $e) {
            \Log::error('searchLessons error: ' . $e->getMessage());
            throw $e;
        }
    }

}