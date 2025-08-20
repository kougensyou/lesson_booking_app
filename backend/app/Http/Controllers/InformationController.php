<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\InformationService;

class InformationController extends Controller
{

    public function __construct() {
        $this->informationService = new InformationService();
    }

    public function getInformationList(Request $request) {
        return $this->informationService->getInformationList();
    }
}