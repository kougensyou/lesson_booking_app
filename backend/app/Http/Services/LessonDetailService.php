<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use App\Models\Lesson;

class LessonDetailService
{
    public function getLessonDetail($lessonId) {
        try {
            return Lesson::select('id', 'name', 'start_time', 'end_time', 'instructor_id')
            ->where('id', $lessonId)
            ->first();
        } catch (\Throwable $e) {
            \Log::error('getLessonDetail error: ' . $e->getMessage());
            throw $e;
        }
    }

}