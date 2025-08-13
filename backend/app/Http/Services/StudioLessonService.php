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
    public function getStudioLessonData($studioId, $fromDate, $toDate) {
        try {
            $studioLessonList = $this->getStudioLessonList($studioId, $fromDate, $toDate);
            $studioData = $this->getStudioData($studioId);

            return [
                'studio_lesson_list' => $studioLessonList,
                'studio_data' => $studioData,
                'time_options' => config('const.studioLesson.timeOptions'),
            ];
        } catch (\Throwable $e) {
            \Log::error('getStudioLessonData error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getStudioLessonList($studioId, $fromDate, $toDate) {
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
            ->where('lesson.studio_id', $studioId)
            ->whereBetween('lesson.start_time', [$fromDate, $toDate])
            ->get();
    }

    private function getStudioData($studioId) {
        return Studio::select('id', 'studio_name', 'image_path')
        ->where('id', $studioId)
        ->first();
    }

}