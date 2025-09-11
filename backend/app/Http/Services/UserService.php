<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use SendGrid;

class UserService
{

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
            ->first();
        } catch (\Throwable $e) {
            \Log::error('getUser error: ' . $e->getMessage());
            throw $e;
        }
    }

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
                        $oldPath = storage_path('images/user/' . $oldFile);
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

    public function updatePassword($userId, $passwordData) {

        DB::beginTransaction();

        try {

            if ($passwordData['newPassword'] !== $passwordData['newPasswordConfirmation']) {
                throw new CustomErrorResponseException('新しいパスワードと確認用パスワードが一致しません。', 400);
            }

            $user = auth()->user();

            if (!$user || !\Hash::check($passwordData['currentPassword'], $user->password)) {
                throw new CustomErrorResponseException('現在のパスワードが正しくありません。', 400);
            }

            $user->password = \Hash::make($passwordData['newPassword']);
            $user->save();

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('updatePassword error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function sendPasswordResetMail($userId, $destinationEmail) {

        DB::beginTransaction();

        try {

            $email = new \SendGrid\Mail\Mail();
            $email->setFrom('0028tkhr@gmail.com');
            $email->setSubject("テスト送信");
            $email->addTo($destinationEmail);
            $apiKey = getenv('SENDGRID_API_KEY');
            $sendGrid = new \SendGrid($apiKey);
            $email->addContent(
                "text/plain",
                "test mail"
            );
            $response = $sendGrid->send($email);
            if ($response->statusCode() == 202) {
                return back()->with(['success' => "E-mails successfully sent out!!"]);
            }
            return back()->withErrors(json_decode($response->body())->errors);

        } catch (\Throwable $e) {
            \Log::error('sendPasswordResetMail error: ' . $e->getMessage());
            throw $e;
        }
    }
}