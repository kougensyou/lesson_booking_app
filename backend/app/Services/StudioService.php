<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Repositories\StudioRepository;

class StudioService
{
    private StudioRepository $studioRepository;

    public function __construct(StudioRepository $studioRepository)
    {
        $this->studioRepository = $studioRepository;
    }
    
    /**
     * Get a list of studios from the database
     *
     * @return Collection
     */
    public function getStudioList(): Collection
    {
        return $this->studioRepository->getStudioList();
    }

    /**
     * Get a list of favorite studios for the user
     * 
     * @param int $userId User ID
     * @return Collection Favorite studio list
     */
    public function getFavoriteStudioList($userId): Collection
    {
        return $this->studioRepository->getFavoriteStudioList($userId);
    }

    /**
     * Save a list of favorite studios for the user
     *
     * @param int $userId User ID
     * @param array $initialFavoriteStudioList Initial favorite studio list
     * @param array $favoriteStudioList Favorite studio list
     * @throws Throwable
     */
    public function saveFavoriteStudioList($userId, $initialFavoriteStudioList, $favoriteStudioList): void
    {

        DB::beginTransaction();

        try {
            $initialIds = collect($initialFavoriteStudioList)->pluck('id')->all();
            $currentIds = collect($favoriteStudioList)->pluck('id')->all();

            // Delete
            $toDelete = array_diff($initialIds, $currentIds);
            if (!empty($toDelete)) {
                $this->studioRepository->deleteFavoriteStudios($userId, $toDelete);
            }

            // Insert
            $toAdd = array_diff($currentIds, $initialIds);
            foreach ($toAdd as $studioId) {
                $this->studioRepository->addFavoriteStudio($userId, $studioId);
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('saveFavoriteStudioList error: ' . $e->getMessage());
            throw $e;
        }
    }
}
