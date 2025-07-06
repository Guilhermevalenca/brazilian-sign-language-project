<?php

use App\Http\Controllers\UserMonitoringController;
use Illuminate\Support\Facades\Route;

Route::prefix('userMonitoring')
    ->controller(UserMonitoringController::class)
    ->group(function () {

        Route::get('/', 'index');
        Route::get('/{subject}', 'show');

        //Route::middleware(['auth:sanctum', 'ability:user-admin'])
        //->group(function () {
    
        Route::post('/', 'store');
        Route::get('/{subject}/edit', 'edit');
        Route::put('/{subject}', 'update');
        Route::delete('/{subject}', 'destroy');

        //});
    });
