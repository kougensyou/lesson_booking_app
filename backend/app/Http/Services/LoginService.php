<?php
namespace App\Http\Services;

use Illuminate\Http\Response;
use Socialite;

class LoginService
{

    public function getLoginInfo() {
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

}