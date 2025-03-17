<?php

use App\Http\Controllers\KeywordController;
use Illuminate\Support\Facades\Route;

Route::prefix('keywords')
    ->controller(KeywordController::class)
    ->group(function () {

        Route::get('', 'index');
        Route::post('with_filters', 'withFilters');

        Route::middleware(['auth:sanctum', 'ability:user-admin'])
            ->group(function() {

                Route::post('', 'store');
                Route::put('/{keyword}', 'update');
                Route::delete('/{keyword}', 'destroy');

            });

    });