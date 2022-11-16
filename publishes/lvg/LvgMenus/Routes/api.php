<?php

use Illuminate\Http\Request;

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

Route::prefix("v1")
    ->middleware(["auth:sanctum"])
    ->as("api.v1.")
    ->group(function () {
        Route::get("lvg-menus/dt", "Api\LvgMenuController@dt")->name("lvg-menus.dt");
        Route::apiResource("lvg-menus", "Api\LvgMenuController")->parameters(["lvg-menus" => "menu"]);
    });
