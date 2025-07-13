<?php
namespace App\Http\Services;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginService
{

    public function getTokenData(Request $request) {
        try {

            $response = Http::asForm()->post(config('services.passport.login_url'), [
                'grant_type' => config('services.passport.grant_type'),
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
                'username' => $request->username,
                'password' => $request->password,
            ])->throw();

            $tokenData = $response->json();

            return $tokenData;

        }catch( \Exception $e ) {
            \Log::error('ログインエラー: ' . $e->getMessage());
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function getUserData() {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json(['user' => $user]);
    }

}