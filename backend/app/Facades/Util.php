<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Util extends Facade
{
    /**
     * Facadeの登録名を取得する
     * 
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'util';
    }
}