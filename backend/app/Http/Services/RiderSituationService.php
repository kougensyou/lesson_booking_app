<?php
namespace App\Http\Services;

use App\Models\TRiderSituation;
use Carbon\Carbon;

class RiderSituationService
{

    /**
     * コンストラクタ
     */
    public function __construct()
    {
    }

    /**
     * ライダー状況取得
     * @param string $riderNo
     * @return string
     */
    public function getRiderStatus($riderNo): string
    {
        $riderStatus = TRiderSituation::select('m_common.item_value01')
                        ->join('m_common', 't_rider_situation.rider_status', '=', 'm_common.item_id')
                        ->where('t_rider_situation.rider_no', '=', $riderNo)
                        ->whereNull('t_rider_situation.del_flg')
                        ->where('m_common.master_id', '=', config('const.mcommonMasterid.rider_status_div'))
                        ->orderBy('t_rider_situation.cmn_update_date', 'desc')
                        ->first();
        
        return $riderStatus ? $riderStatus->item_value01 : "";
    }
}