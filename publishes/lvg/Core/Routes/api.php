<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['api','auth:sanctum'])
    ->as("api.lvg.")
    ->prefix('lvg')
    ->group(function () {
        /**DO-NOT-REMOVE-ME**/
        Route::get('g-panel/tables/search',
            [\Lvg\Core\Http\Controllers\Api\GPanelController::class,'searchTables'])
            ->name('g-panel.tables.search');
        Route::get('schematics/{schematic}/fields',
            [\Lvg\Core\Http\Controllers\Api\SchematicController::class,'fields'])->name('schematics.schematic.fields');
        Route::get('schematics/{schematic}/relationships',
            [\Lvg\Core\Http\Controllers\Api\SchematicController::class,'relationships'])->name('schematics.schematic.relationships');
        Route::get('schematics/dt',
            [\Lvg\Core\Http\Controllers\Api\SchematicController::class,'dt'])->name('schematics.dt');
        Route::apiResource("schematics","Api\SchematicController");
    });
