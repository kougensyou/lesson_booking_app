<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    private $errorResponseCode = '404';

    /**
     * ロール権限
     * 指定された権限以外のユーザーを制限
     *
     * LaravelのGate機能では上手くいかなかったので、こちらで処理を行う
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  $role
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        $userTypeList = array_flip(config('const.userType'));
        $userType = \Auth::user()->user_type;

        // 権限が存在するか
        if (array_key_exists($userType, $userTypeList) === false) {
            throw new \Exception("403 Access Denied.\nuser type: {$userType}\nuser type list: ".json_encode($userTypeList));
        }

        // アクセス権限がなければエラー表示
        if (in_array($userTypeList[$userType], $role) === false) {
            abort($this->errorResponseCode);
        }

        return $next($request);
    }
}
