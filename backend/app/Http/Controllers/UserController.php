<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PasswordResetMailRequest;
use App\Http\Requests\User\PasswordChangeRequest;
use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Models\User;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get user data for the authenticated user
     * 
     * @return User
     * 
     * @throws \Throwable
     */
    public function getUser(): User
    {
        try {
            $userId = Auth::id();
            return $this->userService->getUser($userId);
        } catch (\Throwable $e) {
            \Log::error('getUser error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update the user data
     *
     * @param UserUpdateRequest $request
     * @return User
     * 
     * @throws \Throwable
     */
    public function updateUser(UserUpdateRequest $request): User
    {
        try {
            $userId = Auth::id();
            $this->userService->updateUser($userId, $request);
            return $this->userService->getUser($userId);
        } catch (\Throwable $e) {
            \Log::error('updateUser error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update the user password
     *
     * @param PasswordChangeRequest $request
     * @return array
     * 
     * @throws \Throwable
     */
    public function updatePassword(PasswordChangeRequest $request): array
    {
        try {
            $userId = Auth::id();
            $passwordData = $request->input('password_data');
            $this->userService->updatePassword($userId, $passwordData);
            return [
                'success' => true,
                'message' => 'The password was updated successfully.'
            ];
        } catch (\Throwable $e) {
            \Log::error('updatePassword error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send password reset mail
     *
     * @param PasswordResetMailRequest $request
     * @return array
     * 
     * @throws \Throwable
     */
    public function sendPasswordResetMail(PasswordResetMailRequest $request): array
    {
        try {
            $toEmail = $request->input('email');
            $this->userService->sendPasswordResetMail($toEmail);
            return [
                'success' => true,
                'message' => 'The password reset mail was sent successfully.'
            ];
        } catch (\Throwable $e) {
            \Log::error('sendPasswordResetMail error: ' . $e->getMessage());
            throw $e;
        }
    }
}
