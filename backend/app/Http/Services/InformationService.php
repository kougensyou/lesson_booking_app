<?php
namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Info;


class InformationService
{
    public function getInformationList() {
        try {
            $sliderInfo = Info::where('kind', config('const.information.infoKindSlider'))
            ->where('visible_flag', true)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->map(function ($item) {
                if ($item->image_path) {
                    $item->image_url = asset('storage/' . ltrim($item->image_path, '/'));
                    return $item;
                }
                $item->image_url = null;
                return $item;
            });
            $gridInfo = Info::where('kind', config('const.information.infoKindGrid'))
            ->where('visible_flag', true)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->map(function ($item) {
                if ($item->image_path) {
                    $item->image_url = asset('storage/' . ltrim($item->image_path, '/'));
                    return $item;
                }
                $item->image_url = null;
                return $item;
            });
            $listInfo = Info::where('kind', config('const.information.infoKindList'))
            ->where('visible_flag', true)
            ->orderBy('sort_order', 'asc')
            ->get();
            return [
                'slider_info' => $sliderInfo,
                'grid_info'   => $gridInfo,
                'list_info'   => $listInfo,
            ];
        } catch (\Throwable $e) {
            \Log::error('getInformationList error: ' . $e->getMessage());
            throw $e;
        }
    }

}