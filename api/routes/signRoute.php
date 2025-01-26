<?php

use App\Http\Controllers\SignController;
use Illuminate\Support\Facades\Route;


Route::prefix('signs')
    ->controller(SignController::class)
    ->whereNumber('sign')
    ->group(function () {

        Route::get('', 'index');
        Route::get('{sign}', 'show');

        Route::middleware('auth:sanctum')
            ->group(function () {

                Route::post('', 'store');
                Route::put('{sign}', 'update');
                Route::delete('{sign}', 'destroy');

            });

    });
