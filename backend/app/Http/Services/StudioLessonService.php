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


class StudioLessonService
{
    public function getStudioLessonData($userId) {
        try {
            $favoriteStudioList = $this->getFavoriteStudioList($userId);
            $studioList = $this->getStudioList();
            $lessonCategoryList = $this->getLessonCategoryList();

            return [
                'favorite_studio_list' => $favoriteStudioList,
                'studio_list' => $studioList,
                'lesson_category_list' => $lessonCategoryList,
                'time_options' => config('const.studioLesson.timeOptions'),
            ];
        } catch (\Throwable $e) {
            \Log::error('getLessonBookingData error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getFavoriteStudioList($userId) {
        return FavoriteStudio::join('studio', 'studio.id', '=', 'favorite_studio.studio_id')
        ->where('favorite_studio.user_id', $userId)
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