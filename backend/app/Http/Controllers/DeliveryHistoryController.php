<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Services\DeliveryHistoryService;
use App\Http\Services\Api\Admin\MasterMaintenanceService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DeliveryHistoryController extends Controller
{

    public function __construct()
    {
        $this->masterMaintenanceService = new MasterMaintenanceService();
        $this->deliveryHistoryService = new DeliveryHistoryService();
    }

    /**
     * 配送履歴一覧を取得
     * @return Json
     */
    public function addDeliveryHistory(Request $request)
    {
        $deliveryHistoryPeriod = $this->masterMaintenanceService->fetchCommon($request);
        return $this->deliveryHistoryService->addDeilveryHistory($deliveryHistoryPeriod);
    }

}