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
        Route::get("lvg-relationships/dt", "Api\LvgRelationshipController@dt")->name(
            "lvg-relationships.dt"
        );
        Route::apiResource("lvg-relationships", "Api\LvgRelationshipController")->parameters(["lvg-relationships" => "relationship"]);
    });
