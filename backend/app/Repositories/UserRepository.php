<?php
namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
                $item->image_url = '/storage/' . ltrim($item->image_path, '/');
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
    public function updatePassword($user, $password): void
    {
        $user->update([
            'password' => \Hash::make($password),
        ]);
    }

    /**
     * Sends a password reset mail to the given email address
     *
     * @param string $toEmail Email address to send the password reset mail to
     * @param string $randomPassword Randomly generated password
     * 
     * @throws \Throwable
     */
    public function sendMail($toEmail, $randomPassword): void
    {
        $body = __('messages.password_changed', ['password' => $randomPassword]);

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = getenv('MAIL_HOST');
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('MAIL_USERNAME');
        $mail->Password   = getenv('MAIL_APPPASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = getenv('MAIL_PORT');

        $mail->setFrom(getenv('SENDER_MAILADDRESS'), 'Sender');
        $mail->addAddress($toEmail);

        $mail->CharSet = 'UTF-8';
        $mail->isHTML(false);
        $mail->Subject = __('messages.password_reset_subject');
        $mail->Body    = $body;

        $mail->send();
    }

    /**
     * Find a user by email address
     * 
     * @param string $toEmail Email address
     * 
     * @return User|null
     */
    public function findUserByEmail($toEmail): ?User
    {
        return User::where('email', $toEmail)->firstOrFail();
    }
}