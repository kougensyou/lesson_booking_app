<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use App\Models\Lesson;

class LessonDetailService
{
    public function getLessonDetail($lessonId) {
        try {
            return Lesson::select(
                    'studio.studio_name as studio_name',
                    'lesson.name as lesson_name',
                    'lesson.explanation as lesson_explanation',
                    'lesson.image_path as lesson_image_path',
                    'lesson.start_time',
                    'lesson.end_time',
                    'instructor.name as instructor_name',
                    'instructor.introduction as instructor_introduction',
                    'instructor.image_path as instructor_image_path'
                )
            ->join('studio', 'studio.id', '=', 'lesson.studio_id')
            ->join('instructor', 'instructor.id', '=', 'lesson.instructor_id')
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
                return $item;
            })
            ->first();

        } catch (\Throwable $e) {
            \Log::error('getLessonDetail error: ' . $e->getMessage());
            throw $e;
        }
    }

}