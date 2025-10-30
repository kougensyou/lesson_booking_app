<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\LessonBooking;
use App\Models\LessonCategory;
use App\Models\Lesson;
use App\Models\Studio;

class LessonService
{
    /**
     * Get the next lesson data for a given user
     * 
     * @param int $userId User ID
     * 
     * @return array
     */
    public function getNextLessonData($userId): array
    {
        return LessonBooking::with(['lesson.studio', 'lesson.instructor'])
            ->where('user_id', $userId)
            ->whereNull('done_flag')
            ->whereHas('lesson', fn($query) => $query->where('start_time', '>', Carbon::now()))
            ->get()
            ->sortBy(fn($item) => $item->lesson->start_time)
            ->values()
            ->map(function ($item) {
                $lesson = $item->lesson;
                $studio = $lesson->studio;
                $instructor = $lesson->instructor;

                $start = Carbon::parse($lesson->start_time);
                $end = Carbon::parse($lesson->end_time);

                return [
                    'id' => $lesson->id,
                    'studio_name' => $studio->studio_name,
                    'short_studio_name' => mb_strimwidth($studio->studio_name, 0, config('const.lesson.shortStudioNameChar'), ' ...'),
                    'lesson_name' => $lesson->name,
                    'short_lesson_name' => mb_strimwidth($lesson->name, 0, config('const.lesson.shortLessonNameChar'), ' ...'),
                    'start_time' => $lesson->start_time,
                    'end_time' => $lesson->end_time,
                    'lesson_time' => $start->format('n/j G:i') . ' - ' . $end->format('G:i'),
                    'instructor_name' => $instructor->name,
                    'image_path' => $instructor->image_path,
                    'image_url' => $instructor->image_path ? asset('storage/' . ltrim($instructor->image_path, '/')) : null,
                ];
            })
            ->toArray();
    }

    /**
     * Add a list of lessons from the same studio
     * 
     * @param int $studioId Studio ID
     * 
     * @return LengthAwarePaginator
     */
    public function addSameStudioLessonList($studioId): LengthAwarePaginator
    {
        return Lesson::with(['studio', 'instructor'])
            ->where('studio_id', $studioId)
            ->where('start_time', '>', Carbon::now())
            ->whereDoesntHave('lessonBookings')
            ->orderBy('start_time', 'asc')
            ->paginate(config('const.lesson.pagination'))
            ->through(function ($lesson) {
                $start = Carbon::parse($lesson->start_time);
                $end = Carbon::parse($lesson->end_time);
                $instructor = $lesson->instructor;
                $studio = $lesson->studio;

                return [
                    'id' => $lesson->id,
                    'studio_name' => $studio->studio_name,
                    'short_studio_name' => mb_strimwidth($studio->studio_name, 0, 10, ' ...'),
                    'lesson_name' => $lesson->name,
                    'short_lesson_name' => mb_strimwidth($lesson->name, 0, 15, ' ...'),
                    'start_time' => $lesson->start_time,
                    'end_time' => $lesson->end_time,
                    'lesson_time' => $start->format('n/j G:i') . ' - ' . $end->format('G:i'),
                    'instructor_name' => $instructor->name,
                    'image_path' => $instructor->image_path,
                    'image_url' => $instructor->image_path ? asset('storage/' . ltrim($instructor->image_path, '/')) : null,
                ];
            }); 
    }

    /**
     * Get a list of time options
     * 
     * @return array
     * @return string start_time_options A list of start time options
     * @return string end_time_options A list of end time options
     */
    public function getTimeOptions(): array
    {
        return [
            'start_time_options' => config('const.lesson.startTimeOptions'),
            'end_time_options' => config('const.lesson.endTimeOptions'),
        ];
    }

    /**
     * Get a list of lesson categories
     * 
     * @return Collection
     */
    public function getLessonCategoryList(): Collection
    {
        return LessonCategory::select('id', 'category_name')
        ->get();
    }

    /**
     * Add searched lessons based on the search input form
     * 
     * @param array $searchInputForm Search input form
     * @return LengthAwarePaginator
     */
    public function addSearchedLessons($searchInputForm): LengthAwarePaginator
    {
        return Lesson::with(['studio', 'instructor'])
            ->where('start_time', '>', Carbon::now())
            ->when(!empty($searchInputForm['selectedDates']), function($q) use ($searchInputForm) {
                $q->where(function($q2) use ($searchInputForm) {
                    foreach ($searchInputForm['selectedDates'] as $date) {
                        $q2->orWhereDate('start_time', $date);
                    }
                });
            })
            ->when(!empty($searchInputForm['startTime']), function($q) use ($searchInputForm) {
                $q->whereTime('start_time', '>=', $searchInputForm['startTime']);
            })
            ->when(!empty($searchInputForm['endTime']), function($q) use ($searchInputForm) {
                $q->whereTime('end_time', '<=', $searchInputForm['endTime']);
            })
            ->when(!empty($searchInputForm['lessonCategory']), function($q) use ($searchInputForm) {
                $q->where('lesson_category_id', $searchInputForm['lessonCategory']);
            })
            ->when(!empty($searchInputForm['studio']), function($q) use ($searchInputForm) {
                $q->where('studio_id', $searchInputForm['studio']);
            })
            ->when(!empty($searchInputForm['instructor']), function($q) use ($searchInputForm) {
                $q->whereHas('instructor', fn($qi) => $qi->where('name', 'like', "%{$searchInputForm['instructor']}%"));
            })
            ->when(!empty($searchInputForm['lessonName']), function($q) use ($searchInputForm) {
                $q->where('name', 'like', "%{$searchInputForm['lessonName']}%");
            })
            ->orderBy('start_time', 'asc')
            ->paginate(config('const.lesson.pagination'))
            ->through(function ($lesson) {
                $start = Carbon::parse($lesson->start_time);
                $end = Carbon::parse($lesson->end_time);
                $instructor = $lesson->instructor;
                $studio = $lesson->studio;
                
                return [
                    'id' => $lesson->id,
                    'studio_name' => $studio->studio_name,
                    'short_studio_name' => mb_strimwidth($studio->studio_name, 0, 10, ' ...'),
                    'lesson_name' => $lesson->name,
                    'short_lesson_name' => mb_strimwidth($lesson->name, 0, 15, ' ...'),
                    'start_time' => $lesson->start_time,
                    'end_time' => $lesson->end_time,
                    'lesson_time' => $start->format('n/j G:i') . ' - ' . $end->format('G:i'),
                    'instructor_name' => $instructor->name,
                    'image_path' => $instructor->image_path,
                    'image_url' => $instructor->image_path ? asset('storage/' . ltrim($instructor->image_path, '/')) : null,
                ];
            });
    }

    /**
     * Get lesson detail for a given lesson
     * 
     * @param int $userId User ID
     * @param int $lessonId Lesson ID
     * 
     * @return object
     */
    public function getLessonDetail($userId, $lessonId): object
    {
        $lesson = Lesson::with([
                'studio',
                'instructor',
                'lessonBookings' => fn($q) => $q->where('user_id', $userId)
            ])
            ->findOrFail($lessonId);

        $start = Carbon::parse($lesson->start_time);
        $end = Carbon::parse($lesson->end_time);

        $booked = $lesson->lessonBookings->isNotEmpty();

        return (object) [
            'studio_id' => $lesson->studio->id,
            'studio_name' => $lesson->studio->studio_name,
            'lesson_name' => $lesson->name,
            'lesson_explanation' => $lesson->explanation,
            'lesson_image_path' => $lesson->image_path,
            'lesson_image_url' => $lesson->image_path ? asset('storage/' . ltrim($lesson->image_path, '/')) : null,
            'start_time' => $lesson->start_time,
            'end_time' => $lesson->end_time,
            'lesson_day' => $start->format('n/j'),
            'lesson_time' => $start->format('G:i') . ' - ' . $end->format('G:i'),
            'lesson_datetime' => $start->format('n/j') . ' ' . $start->format('G:i') . ' - ' . $end->format('G:i'),
            'max_user_num' => $lesson->max_user_num,
            'booking_user_num' => $lesson->booking_user_num,
            'empty_flag' => $lesson->max_user_num !== $lesson->booking_user_num,
            'instructor_name' => $lesson->instructor->name,
            'instructor_introduction' => $lesson->instructor->introduction,
            'instructor_image_path' => $lesson->instructor->image_path,
            'instructor_image_url' => $lesson->instructor->image_path ? asset('storage/' . ltrim($lesson->instructor->image_path, '/')) : null,
            'booked_flag' => $booked,
            'done_flag' => $booked ? $lesson->lessonBookings->first()->done_flag : null,
        ];
    }

    /**
     * Get studio lesson data for a given studio and date range
     * 
     * @param int $studioId Studio ID
     * @param string $fromDate Start date of the date range
     * @param string $toDate End date of the date range
     * 
     * @return array Studio lesson data
     */
    public function getStudioLessonData($studioId, $fromDate, $toDate): array
    {
        $studioLessonList = $this->getStudioLessonList($studioId, $fromDate, $toDate);
        $studioData = $this->getStudioData($studioId);

        return [
            'studio_lesson_list' => $studioLessonList,
            'studio_data' => $studioData,
            'time_options' => config('const.lesson.studioTimeOptions'),
        ];
    }

    /**
     * Get a list of studio lessons for a given studio and date range
     * 
     * @param int $studioId Studio ID
     * @param string $fromDate Start date of the date range
     * @param string $toDate End date of the date range
     * 
     * @return array Studio lesson list
     */
    private function getStudioLessonList($studioId, $fromDate, $toDate): array
    {
        return Lesson::with(['instructor', 'studio'])
            ->where('studio_id', $studioId)
            ->where('start_time', '>', Carbon::now())
            ->whereBetween('start_time', [
                Carbon::parse($fromDate)->startOfDay(),
                Carbon::parse($toDate)->endOfDay()
            ])
            ->orderBy('start_time')
            ->get()
            ->reduce(function ($carry, $lesson) {
                $start = Carbon::parse($lesson->start_time);
                $end = Carbon::parse($lesson->end_time);
                $date = $start->format('n/j');
                $hourKey = $start->format('H:00');
                $time = $start->format('H:i');

                $emptyFlag = $lesson->max_user_num !== $lesson->booking_user_num;

                $carry[$date][$hourKey][] = [
                    'lesson_id'      => $lesson->id,
                    'lesson_day'     => $date,
                    'lesson_time'    => $start->format('G:i') . ' - ' . $end->format('G:i'),
                    'start_time'     => $time,
                    'lesson_name'    => $lesson->name,
                    'instructor_name'=> $lesson->instructor->name,
                    'empty_flag'     => $emptyFlag,
                ];

                return $carry;
            }, []);
    }

    /**
     * Get a studio data by studio ID
     * 
     * @param int $studioId Studio ID
     * 
     * @return Studio
     */
    private function getStudioData($studioId): Studio
    {
        return Studio::select('id', 'studio_name')
        ->where('id', $studioId)
        ->firstOrFail();
    }

}