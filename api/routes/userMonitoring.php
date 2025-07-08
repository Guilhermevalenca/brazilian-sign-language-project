<?php

use App\Http\Controllers\UserMonitoringController;
use Illuminate\Support\Facades\Route;

Route::prefix('user-monitoring')
    ->controller(UserMonitoringController::class)
    ->group(function () {

        Route::get('/', 'index');
        Route::post('/', 'store');
    });
