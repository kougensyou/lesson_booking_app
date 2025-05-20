<?php

namespace App\Http\Components\Stream\Filter;

/**
 * 改行コードをCR+LFに変換するフィルタークラス
 * Class CrlfFilter
 * 
 */
class CrlfFilter extends \php_user_filter
{
    function filter($in, $out, &$consumed, $closing) {
        while ($bucket = stream_bucket_make_writeable($in)) {
            $bucket->data = preg_replace("/\n$/", "", $bucket->data);
            $bucket->data = preg_replace("/\r$/", "", $bucket->data);
            $bucket->data = $bucket->data . "\r\n";
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }
        return PSFS_PASS_ON;
    }
}