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

    public function addSameStudioLessonList($studioId) {
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
            ->leftJoin('lesson_booking', 'lesson_booking.lesson_id', '=', 'lesson.id')
            ->whereNull('lesson_booking.id')
            ->where('lesson.start_time', '>', Carbon::now())
            ->where('lesson.studio_id', $studioId)
            ->orderBy('lesson.start_time', 'asc')
            ->paginate(config('const.lesson.pagination'))
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

    public function getTimeOptions() {
        return [
            'start_time_options' => config('const.lesson.startTimeOptions'),
            'end_time_options' => config('const.lesson.endTimeOptions'),
        ];
    }

    public function getLessonCategoryList() {
        try{
            return LessonCategory::select('id', 'category_name')
            ->get();
        } catch (\Throwable $e) {
            \Log::error('getLessonCategoryList error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function addSearchedLessons($searchInputForm) {
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
                ->paginate(config('const.lesson.pagination'))
                ->through(function ($item) {
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
                'lesson.max_user_num',
                'lesson.booking_user_num',
                'instructor.name as instructor_name',
                'instructor.introduction as instructor_introduction',
                'instructor.image_path as instructor_image_path',
                \DB::raw('CASE WHEN lesson_booking.id IS NOT NULL THEN true ELSE false END as reserved_flag'),
                'lesson_booking.done_flag'
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
                $item->empty_flag = $item->max_user_num !== $item->booking_user_num;
                return $item;
            })
            ->first();

        } catch (\Throwable $e) {
            \Log::error('getLessonDetail error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getStudioLessonData($studioId, $fromDate, $toDate) {
        try {
            $studioLessonList = $this->getStudioLessonList($studioId, $fromDate, $toDate);
            $studioData = $this->getStudioData($studioId);

            return [
                'studio_lesson_list' => $studioLessonList,
                'studio_data' => $studioData,
                'time_options' => config('const.lesson.studioTimeOptions'),
            ];
        } catch (\Throwable $e) {
            \Log::error('getStudioLessonData error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getStudioLessonList($studioId, $fromDate, $toDate)
    {
        return Lesson::select(
                'studio.studio_name as studio_name',
                'lesson.id',
                'lesson.name as lesson_name',
                'lesson.start_time',
                'lesson.end_time',
                'lesson.max_user_num',
                'lesson.booking_user_num',
                'instructor.name as instructor_name',
                'instructor.image_path'
            )
            ->join('studio', 'studio.id', '=', 'lesson.studio_id')
            ->join('instructor', 'instructor.id', '=', 'lesson.instructor_id')
            ->where('lesson.start_time', '>', Carbon::now())
            ->where('lesson.studio_id', $studioId)
            ->whereBetween('lesson.start_time', [
                Carbon::parse($fromDate)->startOfDay(),
                Carbon::parse($toDate)->endOfDay()
            ])
            ->orderBy('lesson.start_time')
            ->get()
            ->reduce(function ($carry, $lesson) {
                $start = Carbon::parse($lesson->start_time);
                $end = Carbon::parse($lesson->end_time);
                $date = $start->format('n/j');
                $hourKey = $start->format('H:00');
                $time    = $start->format('H:i');

                $emptyFlag = $lesson->max_user_num !== $lesson->booking_user_num;

                $carry[$date][$hourKey][] = [
                    'lesson_id'      => $lesson->id,
                    'lesson_day'      => $date,
                    'lesson_time'     => $start->format('G:i') . ' - ' . $end->format('G:i'),
                    'start_time'      => $time,
                    'lesson_name'     => $lesson->lesson_name,
                    'instructor_name' => $lesson->instructor_name,
                    'empty_flag'    => $emptyFlag,
                ];
                return $carry;
            }, []);
    }

    private function getStudioData($studioId) {
        return Studio::select('id', 'studio_name')
        ->where('id', $studioId)
        ->first();
    }

}