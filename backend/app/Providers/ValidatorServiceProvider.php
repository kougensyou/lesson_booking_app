<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\CommonValidator;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::resolver(function($translator,$data,$rules,$messages,$attributes){
            return new CommonValidator($translator,$data,$rules,$messages,$attributes);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}