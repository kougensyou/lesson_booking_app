<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\HomeService;

class HomeController extends Controller
{

    public function __construct() {
        $this->homeService = new HomeService();
    }

    public function getHomeData(Request $request) {
        return $this->homeService->getHomeData();
    }

}