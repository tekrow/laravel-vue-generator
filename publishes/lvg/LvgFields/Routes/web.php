<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix(config("lvg.route_prefix", "lvg"))
    ->middleware(["auth:sanctum"])
    ->as("lvg.g-panel.")
    ->group(function () {
        Route::resource("lvg-fields", "LvgFieldController")->parameters(["lvg-fields" => "field"]);
    });
