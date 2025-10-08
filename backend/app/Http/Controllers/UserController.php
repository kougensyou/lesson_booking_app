<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PasswordResetMailRequest;
use App\Http\Requests\User\PasswordChangeRequest;
use App\Http\Requests\User\UserUpdateRequest;
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

    public function updateUser(UserUpdateRequest $request) {
        $userId = Auth::id();
        $this->userService->updateUser($userId, $request);
        return $this->userService->getUser($userId);
    }

    public function updatePassword(PasswordChangeRequest $request) {
        $userId = Auth::id();
        $passwordData = $request->input('password_data');
        return $this->userService->updatePassword($userId, $passwordData);
    }

    public function sendPasswordResetMail(PasswordResetMailRequest $request) {
        $toEmail = $request->input('email');
        return $this->userService->sendPasswordResetMail($toEmail);
    }
}
