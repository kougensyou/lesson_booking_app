<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\HomeService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function __construct() {
        $this->homeService = new HomeService();
    }

    public function getHomeData(Request $request) {
        return [
            'status' => 'success',
            'message' => 'Home data retrieved successfully'
        ];
        //return $this->homeService->getHomeData();
    }

}