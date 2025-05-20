<?php

namespace App\Exceptions;

use App\Http\Components\Log\LogHander;

class CustomErrorResponseException extends BaseErrorResponseException
{

    /**
     * @var string
     */
    protected $exceptionMessage;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string エラー行のキー項目
     */
    protected $errorKeyName;

    /**
     * @var string エラーデータ
     */
    protected $errorValue;

    /**
     * \constructor.
     *
     * @param string $exceptionMessage エクセプションメッセージ(catchした場合は元のエクセプションメッセージ、それ以外はエラー原因等の文字列を渡す)
     * @param string $customMessage 独自エラーメッセージ(ユーザー表示用)
     * @param string $errorKeyName エラーが発生した項目
     * @param string $errorValue エラー値
     */
    public function __construct(string $exceptionMessage, string $message, string $errorKeyName = '', string $errorValue = '')
    {
        $this->exceptionMessage = $exceptionMessage;
        $this->message = $message;
        $this->statusCode = config('const.customError.httpStatusCode.customException');
        //任意項目
        $this->errorKeyName = $errorKeyName;
        $this->errorValue = $errorValue;
    }

    /**
     * @return string
     */
    public function getExceptionMessage(): string
    {
        return $this->exceptionMessage;
    }

    /**
     * @return string
     */
    public function getErrorKeyName(): string
    {
        return $this->errorKeyName;
    }

    /**
     * @return string
     */
    public function getErrorValue(): string
    {
        return $this->errorValue;
    }

    /**
     * ユーザー用のエラーメッセージを返す
     * @return string
     */
    public function getResponseMessage(): string
    {
        $responseMessage = '';
        $responseMessage = $this->message;

        if ($this->errorKeyName) {
            $responseMessage .= ' : '. $this->errorKeyName;
        }

        //エラー値が指定されていた場合
        if ($this->errorValue) {
            $responseMessage .= ' ' . $this->errorValue;
        }

        return $responseMessage;
    }
}