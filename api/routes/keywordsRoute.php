<?php

use App\Http\Controllers\KeywordController;
use Illuminate\Support\Facades\Route;

Route::prefix('keywords')
    ->controller(KeywordController::class)
    ->whereNumber('keyword')
    ->group(function () {

        Route::get('', 'index');
        Route::get('{keyword}', 'show');

        Route::middleware(['auth:sanctum'])
            ->group(function () {

                Route::post('', 'store');
                Route::put('{keyword}', 'update');
                Route::delete('{keyword}', 'destroy');

            });

    });
