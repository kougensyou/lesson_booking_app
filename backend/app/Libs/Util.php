<?php

/**
 * 共通ユーティリティクラス
 * 業務ロジックを含まない関数を定義する
 */
namespace App\Libs;

class Util
{
    /**
     * 郵便番号をハイフン区切りに変換する
     * 第2引数にtrueを指定した場合は先頭に「〒」付与
     * 第2引数は省略可（default false）
     * 
     * @param string $postalCode
     * @param bool $addPrefix
     * @return string
     */
    public function formatPostalCode($postalCode, $addPrefix = false): string
    {
        $wkPostalCode = trim($postalCode);
        // 空欄だったり数字以外や桁数の不正がある場合は編集無しで返却
        if (empty($wkPostalCode) || !is_numeric($wkPostalCode) || strlen($wkPostalCode) !== 7) {
            return $wkPostalCode;
        }
        // ハイフン区切りの郵便番号を返却
        // addPrefix=trueの場合は、郵便番号の前に「〒」を付与
        return ($addPrefix ? '〒' : '') . substr($wkPostalCode, 0, 3) . '-' . substr($wkPostalCode, 3);
    }
}

