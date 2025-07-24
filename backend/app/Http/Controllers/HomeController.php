<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Services\HomeService;

class HomeController extends Controller
{

    public function __construct() {
        $this->homeService = new HomeService();
    }

    public function getHomeData(Request $request) {
        $userId = Auth::id();
        $selectedYear = $request->query('selected_year');
        $selectedMonth = $request->query('selected_month') + 1;
        return $this->homeService->getHomeData($userId, $selectedYear, $selectedMonth);
    }

    public function getSelectedLessonList(Request $request) {
        $userId = Auth::id();
        $selectedYear = $request->query('selected_year');
        $selectedMonth = $request->query('selected_month') + 1;
        return $this->homeService->getSelectedLessonList($userId, $selectedYear, $selectedMonth);
    }

}