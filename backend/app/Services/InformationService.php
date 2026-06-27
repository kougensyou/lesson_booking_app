<?php
namespace App\Services;

use App\Repositories\InformationRepository;

class InformationService
{
    private InformationRepository $informationRepository;

    public function __construct(InformationRepository $informationRepository)
    {
        $this->informationRepository = $informationRepository;
    }
    
    /**
     * Get a list of information from the database
     *
     * @return array
     */
    public function getInformationList(): array
    {
        $sliderInfo = $this->informationRepository->getInformationList(config('const.information.infoKindSlider'));
        $gridInfo = $this->informationRepository->getInformationList(config('const.information.infoKindGrid'));
        $listInfo = $this->informationRepository->getInformationList(config('const.information.infoKindList'));
        return [
            'slider_info' => $sliderInfo,
            'grid_info'   => $gridInfo,
            'list_info'   => $listInfo,
        ];
    }

}
