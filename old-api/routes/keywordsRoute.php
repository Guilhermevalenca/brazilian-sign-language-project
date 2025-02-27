<?php

use App\Http\Controllers\KeywordController;
use Illuminate\Support\Facades\Route;

Route::prefix('keywords')
    ->controller(KeywordController::class)
    ->whereNumber('keyword')
    ->group(function () {

        Route::get('', 'index')
            ->name('keywords.index');
        Route::get('{keyword}', 'show')
            ->name('keywords.show');

        Route::middleware(['auth:sanctum'])
            ->group(function () {

                Route::post('', 'store')
                    ->name('keywords.store');
                Route::put('{keyword}', 'update')
                    ->name('keywords.update');
                Route::delete('{keyword}', 'destroy')
                    ->name('keywords.destroy');

            });

    });
