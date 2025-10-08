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
        $response = $next($request);

        $switch_object = 'Symfony\\Component\\HttpFoundation\\StreamedResponse';

        $csp_header = 
            "img-src 'self' data:; ".
            "frame-ancestors 'self'; ".
            "form-action 'self'; ";

        $output_headers = [
            'Content-Security-Policy' => $csp_header,
            'X-Frame-Options'         => 'SAMEORIGIN',
            'X-Content-Type-Options'  =>  'nosniff',
        ];

        foreach ($output_headers as $header_name => $header_body) {
            $response->headers->set($header_name, $header_body);
        }

        return $response;

    }
}
