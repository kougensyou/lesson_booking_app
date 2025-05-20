<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Http\Services\LoginService;
use App\Http\Services\RiderSituationService;

class LoginController extends Controller {

    protected $loginService;
    protected $riderService;
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->loginService = new LoginService();
        $this->riderService = new RiderSituationService();
    }

    public function loginInfo()
    {
        $response = response()->json([
            'grant_type' => env('GRANT_TYPE'),
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'provider' => env('PROVIDER'),
            'scope' => env('SCOPE')
        ]);
        \Log::debug('ログ確認テスト');
        return $response;
    }

    /**
     * Login
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): object
    {
        $user = $this->loginService->login($request);
        if($user != null){
            Auth::login($user);
            session(['user_id' => $user['rider_no']]);
            return response()->json(['user' => $user]);
        }else{
            return response()->json(['error' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * ユーザー情報取得
     * @return object
     */
    public function getUserInfo(): object
    {
        $user = [
            'rider_no' => \Auth::user()->rider_no,
            'rider_name' => \Auth::user()->rider_name,
            'department_code' => \Auth::user()->department_code,
            'mail_address_company' => \Auth::user()->mail_address_company,
        ];

        // 汎用マスタ情報取得
        list($common, $commonSortData) = $this->loginService->getCommonInfo();

        // ライダー状況取得
        $riderStatus = $this->riderService->getRiderStatus($user['rider_no']);

        return response()->json([
            'const' => config('const'),
            'user' => $user,
            'riderStatus' => $riderStatus,
            'common' => $common,
            'commonSortData' => $commonSortData,
        ]);
    }

    /**
     * Logout
     * @param Request $request
     */
    public function logout(Request $request): object
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['logout_url' => env('GOOGLE_LOGOUT_URL')]);
    }
}