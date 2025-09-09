<?php
namespace App\Http\Services;

use Carbon\Carbon;
use App\Exceptions\CustomErrorResponseException;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserService
{

    public function getUser($userId) {
        $user = User::where('id', $userId)->first();
        if (!$user) {
            throw new CustomErrorResponseException('ユーザーが見つかりません。', 404);
        }
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => Carbon::parse($user->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($user->updated_at)->toDateTimeString(),
        ]);
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