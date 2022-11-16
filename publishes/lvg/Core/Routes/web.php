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

use Illuminate\Support\Facades\Route;

Route::prefix(config('lvg.route_prefix','lvg'))
    ->middleware(['auth:sanctum'])
    ->as("lvg.")
    ->group(function() {
        Route::get('/', 'LvgController@index')->name('backend.index');
        Route::prefix('/g-panel')->as('g-panel.')->group(function (){
            Route::get('', [\Lvg\Core\Http\Controllers\GPanelController::class,'index'])->name('index');
//            Route::resource('schematics',"LvgSchematicController");
        });
        Route::resource("lvg-menu","LvgMenuController");
    });
