<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Info;


class InformationRepository
{
    /**
     * Get a list of information from the database
     * 
     * @param int $infoKind
     *
     * @return \Illuminate\Support\Collection
     */
    public function getInformationList($infoKind): Collection
    {
        return Info::where('kind', $infoKind)
        ->where('visible_flag', true)
        ->orderBy('sort_order', 'asc')
        ->get()
        ->map(function ($item) {
            if ($item->image_path) {
                $item->image_url = '/storage/' . ltrim($item->image_path, '/');
                return $item;
            }
            $item->image_url = null;
            return $item;
        });
    }

}