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


class LessonBookingService
{

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

    public function getSelectedLessonList($userId, $selectedYear, $selectedMonth) {
        try{
            $startOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
            $endOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();
            return LessonBooking::select(
                'done_flag',
                'lesson.start_time',
            )
            ->join('lesson', 'lesson.id', '=', 'lesson_booking.lesson_id')
            ->whereBetween('lesson.start_time', [
                $startOfMonth,
                $endOfMonth
            ])
            ->where('lesson_booking.user_id', $userId)
            ->orderBy('lesson.start_time', 'asc')
            ->get();
        } catch (\Throwable $e) {
            \Log::error('getSelectedLessonList error: ' . $e->getMessage());
            throw $e;
        }
    }


}