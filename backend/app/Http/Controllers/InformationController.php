<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\InformationService;

class InformationController extends Controller
{

    public function __construct() {
        $this->informationService = new InformationService();
    }
    
    /**
     * Get a list of information from the database
     *
     * @param Request $request
     * @return mixed
     */
    public function getInformationList(Request $request) {
        return $this->informationService->getInformationList();
    }
}