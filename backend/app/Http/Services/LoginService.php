<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use Socialite;
use App\Models\Rider;
use App\Models\MCommon;

class LoginService
{

    /**
     * コンストラクタ
     * 
     */
    public function __construct()
    {
    }

    /**
     * ライダーマスタからログインユーザ情報を取得
     * 
     * @param Request $request
     * @return Rider
     */
    public function login(Request $request): ?Rider
    {
        try {
            $accessToken = $request->input('token');
            $googleUser = Socialite::driver('google')->userFromToken($accessToken);
            $user = Rider::select('id', 'rider_no', 'rider_name', 'department_code', 'mail_address_company')
                        ->where('mail_address_company', $googleUser->email)
                        ->whereNull('del_flg')
                        ->first();
        } catch (\Exception $e) {
            return null;
        }
        return $user;
    }

    /**
     * 汎用マスタ情報取得
     * 
     * @return array
     */
    public function getCommonInfo(): array
    {
        $common = [];
        $commonSortData = [];
        $commonData = MCommon::orderBy('master_id', 'asc')->orderBy('sort_seq', 'asc')->get();
        foreach ($commonData as $key => $value) {
            $common[$value->master_id][strval($value->item_id)] = $value;
        }
        // ソート用データ
        foreach ($commonData as $key => $value) {
            $commonSortData[$value->master_id][] = $value;
        }

        return [$common, $commonSortData];
    }

}