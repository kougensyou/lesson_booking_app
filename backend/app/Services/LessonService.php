<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\LessonRepository;

class LessonService
{
    private LessonRepository $lessonRepository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * Get the next lesson data for a given user
     * 
     * @param int $userId User ID
     * 
     * @return array
     */
    public function getNextLessonData($userId): array
    {
        return $this->lessonRepository->getNextLessonData($userId);
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
        return $this->lessonRepository->addSameStudioLessonList($studioId);
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
        return $this->lessonRepository->getLessonCategoryList();
    }

    /**
     * Add searched lessons based on the search input form
     * 
     * @param array $searchInputForm Search input form
     * @return LengthAwarePaginator
     */
    public function addSearchedLessons($searchInputForm): LengthAwarePaginator
    {
        return $this->lessonRepository->addSearchedLessons($searchInputForm);
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
        $lesson = $this->lessonRepository->getLessonDetail($userId, $lessonId);

        $start = Carbon::parse($lesson->start_time);
        $end = Carbon::parse($lesson->end_time);

        $booked = $lesson->lessonBookings->isNotEmpty();

        return (object) [
            'studio_id' => $lesson->studio->id,
            'studio_name' => $lesson->studio->studio_name,
            'lesson_name' => $lesson->name,
            'lesson_explanation' => $lesson->explanation,
            'lesson_image_path' => $lesson->image_path,
            'lesson_image_url' => $lesson->image_path ? '/storage/' . ltrim($lesson->image_path, '/') : null,
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
            'instructor_image_url' => $lesson->instructor->image_path ? '/storage/' . ltrim($lesson->instructor->image_path, '/') : null,
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
        $studioLessonList = $this->lessonRepository->getStudioLessonList($studioId, $fromDate, $toDate);
        $studioData = $this->lessonRepository->getStudioData($studioId);

        return [
            'studio_lesson_list' => $studioLessonList,
            'studio_data' => $studioData,
            'time_options' => config('const.lesson.studioTimeOptions'),
        ];
    }

}
