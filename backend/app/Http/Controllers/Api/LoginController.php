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
        try {

            $response = response()->json([
                'grant_type' => env('GRANT_TYPE'),
                'client_id' => env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET'),
                'provider' => env('PROVIDER'),
                'scope' => env('SCOPE')
            ]);
            \Log::debug('ログ確認テスト' . $response->getContent());
            return $response;

        }catch( \Exception $e ) {
            \Log::error('ログイン情報取得エラー: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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