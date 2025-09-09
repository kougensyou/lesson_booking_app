<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Services\UserService;

class UserController extends Controller
{

    public function __construct() {
        $this->userService = new UserService();
    }

    public function getUser() {
        $userId = Auth::id();
        return $this->userService->getUser($userId);
    }

    public function updatePassword(Request $request) {
        $userId = Auth::id();
        $passwordData = $request->input('password_data');
        return $this->userService->updatePassword($userId, $passwordData);
    }
}
