<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Info;


class InformationService
{
    /**
     * Get a list of information from the database
     *
     * @return array
     */
    public function getInformationList(): array
    {
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
    }

}