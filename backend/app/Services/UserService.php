<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use SendGrid;
use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Get user data for the given user ID
     * 
     * @param int $userId User ID
     * 
     * @return User
     */
    public function getUser($userId): User
    {
        return $this->userRepository->getUser($userId);
    }

    /**
     * Update user data
     *
     * @param int $userId User ID
     * @param \Illuminate\Http\Request $request Request object
     *
     * @throws \Throwable
     */
    public function updateUser($userId, Request $request): void
    {

        DB::beginTransaction();

        try {

            $userData = json_decode($request->input('user'), true);

            $updateData = [
                'name' => $userData['name'],
                'email' => $userData['email'],
                'zip_code' => $userData['zip_code'],
                'address' => $userData['address'],
                'birth_date' => Carbon::parse($userData['birth_date'])->format('Y-m-d'),
                'tel_no' => $userData['tel_no'],
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $newPath = $file->storeAs('images/user', $file->getClientOriginalName(), 'public');
                $updateData['image_path'] = '/' . $newPath;

                if (!empty($userData['image_path'])) {
                    $oldFile = basename($userData['image_path']);
                    $newFile = basename($newPath);
                    if ($oldFile !== $newFile) {
                        $oldPath = base_path('storage/app/public/images/user/' . $oldFile);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                }
            }

            $this->userRepository->updateUser($userId, $updateData);

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('updateUser error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update the user password
     *
     * @param int $userId User ID
     * @param array $passwordData Password data array containing the new password and its confirmation
     *
     * @throws \Throwable
     */
    public function updatePassword($userId, $passwordData): void
    {

        DB::beginTransaction();

        try {
            $user = auth()->user();

            $this->userRepository->updatePassword($user, $passwordData);

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('updatePassword error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Sends a password reset mail to the given email address
     *
     * @param string $toEmail Email address to send the password reset mail to
     * 
     * @return RedirectResponse
     * 
     * @throws \Throwable
     */
    public function sendPasswordResetMail($toEmail): RedirectResponse
    {

        DB::beginTransaction();

        try {

            $randomPassword = Str::random(12);

            $this->userRepository->updatePasswordForReset($toEmail, $randomPassword);

            return $this->userRepository->sendMail($toEmail, $randomPassword);

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('sendPasswordResetMail error: ' . $e->getMessage());
            throw $e;
        }
    }

}
