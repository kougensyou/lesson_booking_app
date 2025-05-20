<?php
namespace App\Http\Services;

use Illuminate\Validation\Validator;


class CommonValidator extends Validator
{
    /*
    * 共通カスタムバリデーション
    */

    // 英数字のみ（日本語禁止）
    public function validateAlphaNumeric($attribute,$value,$parameters){
        return (preg_match("/^[a-z0-9]+$/i", $value));
    }

    // ローマ字のみ（日本語禁止）
    public function validateAlphabet($attribute,$value,$parameters){
        return (preg_match("/^[a-zs]+$/i", $value));
    }
   // 半角・全角数字のみ
    public function validateMbOkNumeric($attribute,$value,$parameters){
        return (preg_match("/^[0-9０-９]+$/i", $value));
    }
   // 全角のみ
    public function validateZenkakuOk($attribute,$value,$parameters){
        return (preg_match("/^[^\x01-\x7E\x{FF61}-\x{FF9F}]+$/u", $value));
    }
    // 数字と下線のみ
    public function validateNumUnder($attribute,$value,$parameters){
        return (preg_match("/^[0-9_]+$/", $value));
    }
}