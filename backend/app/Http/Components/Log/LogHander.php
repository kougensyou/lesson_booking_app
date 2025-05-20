<?php

namespace App\Http\Components\Log;

class LogHander
{

    protected $message;

    protected $logLevel;

    protected $userInfo;

    /**
     * constructor
     *
     * @param Array $message
     * @param String $logLevel
     */
    public function __construct( Array $message, $logLevel = 'error' )
    {
        $this->message = print_r($message,true);
        $this->logLevel = $logLevel;
        $this->userInfo = \Auth::user()->user_id;
    }

    /**
     * ログを出力
     *
     * @param array $data
     * @return array
     */
    function setErrorLogSimple() {
        $logMessage = print_r(
                            [
                                'user' => $this->userInfo,
                                'message' => $this->message,
                            ]
                    ,true);
        // $logMessage = json_encode($logMessage,JSON_UNESCAPED_UNICODE);

        switch ($this->logLevel) {
            case 'debug':
                \Log::debug($logMessage);
                break;
            case 'info':
                \Log::info($logMessage);
                break;
            case 'notice':
                \Log::notice($logMessage);
                break;
            case 'warning':
                \Log::warning($logMessage);
                break;
            case 'error':
                \Log::error($logMessage);
                break;
            case 'critical':
                \Log::critical($logMessage);
                break;
            case 'alert':
                \Log::alert($logMessage);
                break;
            case 'emergency':
                \Log::emergency($logMessage);
                break;
        }
    }
}