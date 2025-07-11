<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Services\LoginService;

class LoginController extends Controller {

    protected $loginService;
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    public function loginInfo()
    {
        return $this->loginService->getLoginInfo();
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