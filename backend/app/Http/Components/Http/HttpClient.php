<?php

namespace App\Http\Components\Http;

class HttpClient
{
    protected $method;

    protected $url;

    protected $params;

    protected $client;

    public $response;

    /**
     * パラメータを受け取りhttpリクエスト実行(実行結果はインスタンスプロパティの$responseから取得)
     * @param  String $method
     * @param  String $url
     * @param  Array $params
     */
    public function __construct( String $method, String $url, Array $params )
    {
        $this->method = $method;
        $this->url = $url;
        $this->params = $params;

        //httpリクエスト
        $this->client = new \GuzzleHttp\Client();
        $this->response = $this->client->request(
            $this->method,
            $this->url,
            $this->params
        );
    }
}
