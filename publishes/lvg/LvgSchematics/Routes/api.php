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
        Route::get("lvg-schematics/dt", "Api\LvgSchematicController@dt")->name(
            "lvg-schematics.dt"
        );
        Route::apiResource("lvg-schematics", "Api\LvgSchematicController")->parameters(["lvg-schematics" => "schematic"]);
    });
