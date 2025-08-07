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
    public function getLessonBookingData($userId) {
        try {
            $favoriteStudioList = $this->getFavoriteStudioList($userId);
            $studioList = $this->getStudioList();
            $lessonCategoryList = $this->getLessonCategoryList();

            return [
                'favorite_studio_list' => $favoriteStudioList,
                'studio_list' => $studioList,
                'lesson_category_list' => $lessonCategoryList,
                'start_time_options' => config('const.lessonBooking.startTimeOptions'),
                'end_time_options' => config('const.lessonBooking.endTimeOptions'),
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
        return Studio::select('id', 'studio_name')
        ->get();
    }

    private function getLessonCategoryList() {
        return LessonCategory::select('id', 'category_name')
        ->get();
    }

    public function searchLessons($searchInputForm) {
        try {
        } catch (\Throwable $e) {
            \Log::error('searchLessons error: ' . $e->getMessage());
            throw $e;
        }
    }

}