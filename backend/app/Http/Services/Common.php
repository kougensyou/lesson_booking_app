<?php

namespace App\Http\Services;

class Common
{
    /**
     * 文字列補完処理
     * 
     * @param String $basestr
     * @param Array $replaceStrs
     */
    public static function compString($basestr, ...$replaceStrs)
    {
        $value = $basestr;
        // 文字列「{数字}」を第二引数で指定した配列で1から置換
        // 例：$basestr → '{1}を{2}に入力してください。'
        // 　　$replaceStrs →　['文字列', '画面']
        // 　　戻り値：'文字列を画面に入力してください。' 
        for($i = 0; $i < count($replaceStrs); $i++)
        {
            $value = str_replace('{' . ($i + 1) . '}', $replaceStrs[$i], $value);
        }
        return $value;
    }

}