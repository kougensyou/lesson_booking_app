<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
}