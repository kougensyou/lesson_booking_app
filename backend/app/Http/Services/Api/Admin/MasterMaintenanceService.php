<?php
namespace App\Http\Services\Api\Admin;

use Carbon\Carbon;
use App\Models\MCommon;
use App\Exceptions\CustomErrorResponseException;

class MasterMaintenanceService
{
    /**
     * 汎用マスタ取得
     *
     * @param  Illuminate\Http\Request $request
     * @return \App\Models\MCommon
     */
    public function fetchCommon($request)
    {
        return MCommon::where('master_id', $request->input('master_id'))->orderBy('sort_seq', 'asc')->get();
    }

    /**
     * 汎用マスタ更新
     *
     * @param  \App\Http\Requests\Api\Admin\MasterMaintenance\UpdateRequest $request
     */
    public function updateCommon($request)
    {
        $masterId = $request->input('master_id');
        $masterName = $request->input('master_name');
        $div = config('const.div.qtnet');
        $userId = \Auth::user()->user_id;
        $isUpdateMasterName = false;
        $errorItem = '';

        // 項目名称のみ更新する場合のエラー設定を切り替え
        if (count($request->input('common')) === 0) {
            $errorAttr = \Lang::get('validation.attributes.master_name');
        } else {
            $errorAttr = \Lang::get('validation.attributes.item_id');
        }

        // 項目名称を更新するかどうか
        if (MCommon::where([ 'master_id' => $masterId, 'master_name' => $masterName ])->count() === 0) {
            $isUpdateMasterName = true;
        }

        \DB::beginTransaction();

        try {
            foreach( $request->input('common') as $common) {
                $errorItem = $common['item_id'];

                // 新規登録
                if ($common['state'] === 'add') {
                    $newCommon = new MCommon;
                    $newCommon->master_id = $masterId;
                    $newCommon->master_name = $masterName;
                    $newCommon->item_id = $common['item_id'];
                    $newCommon->item_code01 = $common['item_code01'];
                    $newCommon->item_code02 = $common['item_code02'];
                    $newCommon->item_code03 = $common['item_code03'];
                    $newCommon->item_code04 = $common['item_code04'];
                    $newCommon->item_code05 = $common['item_code05'];
                    $newCommon->item_value01 = $common['item_value01'];
                    $newCommon->item_value02 = $common['item_value02'];
                    $newCommon->item_value03 = $common['item_value03'];
                    $newCommon->item_value04 = $common['item_value04'];
                    $newCommon->item_value05 = $common['item_value05'];
                    $newCommon->item_number01 = $common['item_number01'];
                    $newCommon->item_number02 = $common['item_number02'];
                    $newCommon->item_number03 = $common['item_number03'];
                    $newCommon->sort_seq = $common['sort_seq'];
                    $newCommon->cmn_create_div = $div;
                    $newCommon->cmn_create_id = $userId;
                    $newCommon->cmn_update_div = $div;
                    $newCommon->cmn_update_id = $userId;
                    $newCommon->save();
                }
                // 削除
                elseif (isset($common['delete']) && $common['delete'] === true) {
                    MCommon::where([
                        'master_id' => $masterId,
                        'item_id' => $common['item_id'],
                    ])->delete();
                }
                // 更新
                elseif ($common['state'] === 'update') {
                    \DB::table('m_common')->where([
                        'master_id' => $masterId,
                        'item_id' => $common['item_id'],
                    ])->update([
                        'master_name' => $masterName,
                        'item_code01' => $common['item_code01'],
                        'item_code02' => $common['item_code02'],
                        'item_code03' => $common['item_code03'],
                        'item_code04' => $common['item_code04'],
                        'item_code05' => $common['item_code05'],
                        'item_value01' => $common['item_value01'],
                        'item_value02' => $common['item_value02'],
                        'item_value03' => $common['item_value03'],
                        'item_value04' => $common['item_value04'],
                        'item_value05' => $common['item_value05'],
                        'item_number01' => $common['item_number01'],
                        'item_number02' => $common['item_number02'],
                        'item_number03' => $common['item_number03'],
                        'sort_seq' => $common['sort_seq'],
                        'cmn_update_div' => $div,
                        'cmn_update_id' => $userId,
                        'cmn_update_date' => Carbon::now(),
                    ]);
                }
            }

            // 項目名称が変更されていればマスタIDに紐づくものを全て更新
            if ($isUpdateMasterName) {
                MCommon::where('master_id', $masterId)->update(['master_name' => $masterName]);
            }

        } catch (\Exception $e) {
            \DB::rollback();
            throw new CustomErrorResponseException(
                $e->getMessage(),
                config('const.customError.errorMessage.dbError'),
                $errorAttr,
                $errorItem
            );
        }

        \DB::commit();
    }
}