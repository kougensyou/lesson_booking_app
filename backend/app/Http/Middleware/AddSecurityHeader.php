<?php

namespace App\Http\Middleware;

use Closure;

class AddSecurityHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // レスポンス用オブジェクトの取得
        $response = $next($request);

        // headerメソッドではなく、headersメソッドを利用するクラス
        $switch_object = 'Symfony\\Component\\HttpFoundation\\StreamedResponse';

        // CSP ヘッダーの組み立て
        $csp_header = 
            // "default-src 'self'; ".
            // "script-src 'unsafe-eval' 'self'; ".
            // "style-src 'unsafe-inline' 'self' https://fonts.googleapis.com; ".
            // "font-src 'self' https://fonts.gstatic.com https://fonts.googleapis.com; ".
            "img-src 'self' data:; ".
            "frame-ancestors 'self'; ".
            "form-action 'self'; ";


        $output_headers = [
            // CSPヘッダー追加
            'Content-Security-Policy' => $csp_header,
            // クリックジャッキング対策
            'X-Frame-Options'         => 'SAMEORIGIN',
            // MIME タイプのスニッフィングを抑止
            'X-Content-Type-Options'  =>  'nosniff',
        ];


        // symfony由来レスポンスヘッダーの時
        if( $response instanceof $switch_object ){
            foreach($output_headers as $header_name => $header_body) {
                $response->headers->set($header_name, $header_body);
            }

        // それ以外
        } else {
            foreach($output_headers as $header_name => $header_body) {
                $response->header($header_name, $header_body);
            }
        }

        return $response;

    }
}
