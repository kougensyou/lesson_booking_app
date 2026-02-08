<?php
namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use SendGrid;

class UserRepository
{

    /**
     * Get user data for the given user ID
     * 
     * @param int $userId User ID
     * 
     * @return User
     */
    public function getUser($userId): User
    {
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
    }

    /**
     * Update user data
     *
     * @param int $userId User ID
     * @param array $updateData Data to update
     *
     * @throws \Throwable
     */
    public function updateUser($userId, $updateData): void
    {
        User::where('id', '=', $userId)
            ->update($updateData);
    }

    /**
     * Update the user password
     *
     * @param User $user User model instance
     * @param array $passwordData Password data array containing the new password and its confirmation
     *
     * @throws \Throwable
     */
    public function updatePassword($user, $passwordData): void
    {

        $user->update([
            'password' => \Hash::make($passwordData['new_password']),
        ]);

    }

    /**
     * Sends a password reset mail to the given email address
     *
     * @param string $toEmail Email address to send the password reset mail to
     * @param string $randomPassword Randomly generated password
     * 
     * @return RedirectResponse
     * 
     * @throws \Throwable
     */
    public function sendMail($toEmail, $randomPassword): RedirectResponse
    {
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
    }

    /**
     * Update the user password to a randomly generated string
     * 
     * @param string $toEmail
     * @param string $randomPassword
     */
    public function updatePasswordForReset($toEmail, $randomPassword): void
    {
        
        $user = User::where('email', $toEmail)->firstOrFail();
        
        $user->update([
            'password' => \Hash::make($randomPassword),
        ]);

        DB::commit();

    }
}