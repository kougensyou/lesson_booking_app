<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use Illuminate\Support\Facades\DB;
use App\Models\Lesson;

class BookDoneService
{
    public function getBookDoneData($studioId) {
        try {
            $sameStudioLessonList = $this->getSameStudioLessonList($studioId);

            return [
                'same_studio_lesson_list' => $sameStudioLessonList,
            ];
        } catch (\Throwable $e) {
            \Log::error('getBookDoneData error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getSameStudioLessonList($studioId) {
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
    }

}