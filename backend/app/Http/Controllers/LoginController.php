<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Services\LoginService;

class LoginController extends Controller {

    protected $loginService;
    
    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    public function login(Request $request)
    {
        $tokenData = $this->loginService->getTokenData($request);
        return response()
                ->json($tokenData)
                ->cookie('access_token', $tokenData['access_token'] ?? null, 60, null, null, true, true, false, 'Strict');
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