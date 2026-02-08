<?php
namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\LessonBooking;
use App\Models\LessonCategory;
use App\Models\Lesson;
use App\Models\Studio;

class LessonRepository
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
        return Lesson::with([
                'studio',
                'instructor',
                'lessonBookings' => fn($q) => $q->where('user_id', $userId)
            ])
            ->findOrFail($lessonId);
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
    public function getStudioLessonList($studioId, $fromDate, $toDate): array
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
    public function getStudioData($studioId): Studio
    {
        return Studio::select('id', 'studio_name')
        ->where('id', $studioId)
        ->firstOrFail();
    }

}