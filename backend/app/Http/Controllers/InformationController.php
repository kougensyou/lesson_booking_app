<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\InformationService;

class InformationController extends Controller
{
    private InformationService $informationService;

    public function __construct(InformationService $informationService)
    {
        $this->informationService = $informationService;
    }
    
    /**
     * Get a list of information from the database
     *
     * @param Request $request
     * @return array
     * 
     * @throws \Throwable
     */
    public function getInformationList(Request $request): array
    {
        try {
            return $this->informationService->getInformationList();
        } catch (\Throwable $e) {
            \Log::error('getInformationList error: ' . $e->getMessage());
            throw $e;
        }
    }
}
