<?php
namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use SendGrid;

class UserService
{

    /**
     * Get user data for the given user ID
     * 
     * @param int $userId User ID
     * 
     * @return \Illuminate\Support\Collection
     * 
     * @throws \Throwable
     */
    public function getUser($userId) {
        try {
            return User::select('id', 'name', 'email', 'zip_code', 'address', 'birth_date', 'tel_no', 'image_path')
            ->where('id', $userId)
            ->get()
            ->map(function ($item) {
                if ($item->image_path) {
                    $item->image_url = asset('storage/' . ltrim($item->image_path, '/'));
                    return $item;
                }
                $item->image_url = null;
                return $item;
            })
            ->firstOrFail();
        } catch (\Throwable $e) {
            \Log::error('getUser error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update user data
     *
     * @param int $userId User ID
     * @param \Illuminate\Http\Request $request Request object
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function updateUser($userId, Request $request) {

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
                $newPath = $file->store('images/user', 'public');
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

            User::where('id', '=', $userId)
            ->update($updateData);

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
     *
     * @return void
     */
    public function updatePassword($userId, $passwordData) {

        DB::beginTransaction();

        try {
            $user = auth()->user();
            $user->password = \Hash::make($passwordData['new_password']);
            $user->save();

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
     * @throws \Throwable
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendPasswordResetMail($toEmail) {

        DB::beginTransaction();

        try {

            $randomPassword = Str::random(12);

            $this->updatePasswordForReset($toEmail, $randomPassword);

            $body = __('messages.password_changed', ['password' => $randomPassword]);

            $email = new \SendGrid\Mail\Mail();
            $email->setFrom(getenv('SENDGRID_FROM_EMAIL'));
            $email->setSubject(__('messages.password_reset_subject'));
            $email->addTo($toEmail);
            $apiKey = getenv('SENDGRID_API_KEY');
            $sendGrid = new \SendGrid($apiKey);
            $email->addContent(
                "text/plain",
                $body
            );
            $response = $sendGrid->send($email);
            if ($response->statusCode() == 202) {
                return back()->with(['success' => "E-mails successfully sent out!!"]);
            }
            return back()->withErrors(json_decode($response->body())->errors);

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('sendPasswordResetMail error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update the user password to a randomly generated string
     * 
     * @param string $toEmail
     * @param string $randomPassword
     * 
     * @return void
     */
    private function updatePasswordForReset($toEmail, $randomPassword) {
        
            $user = User::where('email', $toEmail)->firstOrFail();
            $user->password = \Hash::make($randomPassword);
            $user->save();

            DB::commit();
    }
}