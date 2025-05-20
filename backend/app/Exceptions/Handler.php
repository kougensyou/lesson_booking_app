<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use App\Exceptions\CustomErrorResponseException;
use App\Http\Components\Log\LogHander;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    // 未ログイン時のリダイレクト
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Unauthenticated.',
                'message' => $exception->getMessage(),
            ], 401);
        }
        //未認証のリダイレクト先
        return redirect()->guest(route('login'));
    }

    /**
     * Report or log an exception.
     *
     * @param  Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        //カスタムエラー判定を追加
        if ($exception instanceof CustomErrorResponseException) {
            return $this->customErrorResponse($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Custom Error Json HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Exceptions\CustomErrorResponseException  $exception
     * @return Json
     */
    public function customErrorResponse($request, CustomErrorResponseException $exception){
        $data = [
            'status' => 'error',
            'message' => $exception->getResponseMessage(),
            'errors' => ['custom Error' => 
                            [ 'errorMessage' => $exception->getResponseMessage()]
                        ]
        ];

        //ログ出力してエラーレスポンスを返す
        $logMessage = [
            'exception' => $exception->getExceptionMessage(),
            'userResponseMessage' => $exception->getResponseMessage()
        ];
        $logHandler = new LogHander( $logMessage, 'error' );
        $logHandler->setErrorLogSimple();

        return response()->json( $data, $exception->getStatusCode() );
    }
}
