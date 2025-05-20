<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Delivery;
use App\Models\DeliveryStatus;

class DeliveryHistoryService
{
    /**
     * 配送履歴データ取得
     * @param  \Illuminate\Database\Eloquent\Collection  $deliveryHistoryPeriod
     */
    public function addDeilveryHistory($deliveryHistoryPeriod)
    {
        // 検索日時の設定
        $days = $deliveryHistoryPeriod->pluck('item_number01');
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $pastDay = Carbon::now()->subDays($days[0])->format('Y-m-d H:i:s');

        // 表示項目を取得するサブクエリ設定
        $productDivSubQuery = Order::select('product_div')
            ->whereColumn('t_order.order_date', 't_delivery_status.order_date')
            ->whereColumn('t_order.inquiry_no', 't_delivery_status.inquiry_no')
            ->limit(1)
            ->toSql();

        $productDivSubQuery = "($productDivSubQuery)";

        $pickupAddressSubQuery = Delivery::select('start_address')
            ->whereColumn('t_delivery.order_date', 't_delivery_status.order_date')
            ->whereColumn('t_delivery.inquiry_no', 't_delivery_status.inquiry_no')
            ->orderBy('t_delivery.start_delivery_seq', 'ASC')
            ->limit(1)
            ->toSql();

        $pickupAddressSubQuery = "($pickupAddressSubQuery) AS pickup_address";

        $destinationAddressSubQuery = Delivery::select('end_address')
            ->whereColumn('t_delivery.order_date', 't_delivery_status.order_date')
            ->whereColumn('t_delivery.inquiry_no', 't_delivery_status.inquiry_no')
            ->orderBy('t_delivery.end_delivery_seq', 'DESC')
            ->limit(1)
            ->toSql();

        $destinationAddressSubQuery = "($destinationAddressSubQuery) AS destination_address";

        $submitFileFlagSubQuery = DB::raw("
            CASE 
                WHEN t_submit_file_upload.order_date IS NOT NULL THEN true 
                ELSE false 
            END AS invoice_upload_flag
        ");

        $sendEndDateSubQuery = Delivery::select('send_end_date')
            ->whereColumn('t_delivery.order_date', 't_delivery_status.order_date')
            ->whereColumn('t_delivery.inquiry_no', 't_delivery_status.inquiry_no')
            ->orderBy('t_delivery.end_delivery_seq', 'DESC')
            ->limit(1)
            ->toSql();

        $sendEndDateSubQuery = "($sendEndDateSubQuery)";
        
        // 配送履歴データ取得
        $deliveryHistoryList = DeliveryStatus::select(
                't_delivery_status.order_date', 
                't_delivery_status.inquiry_no', 
                DB::raw($productDivSubQuery),
                DB::raw($sendEndDateSubQuery), 
                DB::raw($pickupAddressSubQuery), 
                DB::raw($destinationAddressSubQuery), 
                DB::raw($submitFileFlagSubQuery))
            ->join('t_delivery', function ($join) {
                $join->on('t_delivery.order_date', '=', 't_delivery_status.order_date')
                    ->on('t_delivery.inquiry_no', '=', 't_delivery_status.inquiry_no');
            })
            ->leftJoin('t_submit_file_upload', function ($join) {
                $join->on('t_submit_file_upload.order_date', '=', 't_delivery.order_date')
                    ->on('t_submit_file_upload.inquiry_no', '=', 't_delivery.inquiry_no')
                    ->on('t_submit_file_upload.rider_no', '=', 't_delivery.delivery_rider_no');
            })
            ->leftJoin('t_order', function ($join) {
                $join->on('t_order.order_date', '=', 't_delivery_status.order_date')
                    ->on('t_order.inquiry_no', '=', 't_delivery_status.inquiry_no');
            })
            ->where('t_delivery.delivery_rider_no', session('user_id'))
            ->whereRaw("{$sendEndDateSubQuery} BETWEEN ? AND ?", [$pastDay, $today])
            ->where('t_delivery_status.active_delivery_seq', config('const.deliveryHistory.completeSequence'))
            ->where('t_delivery_status.delivery_status', config('const.deliveryHistory.completeStatus'))
            ->groupBy('t_delivery_status.order_date', 't_delivery_status.inquiry_no', 't_submit_file_upload.order_date')
            ->orderBy(DB::raw($sendEndDateSubQuery), 'DESC')
            ->paginate(config('const.deliveryHistory.pagination'));

        return $deliveryHistoryList;
    }

}