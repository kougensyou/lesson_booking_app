<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('login_info', [LoginController::class , 'loginInfo']);
Route::post('logout', [LoginController::class , 'logout']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('get_home_data', [HomeController::class , 'getHomeData']);
});
