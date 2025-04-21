<?php

use App\Http\Controllers\SignController;
use Illuminate\Support\Facades\Route;

Route::prefix('signs')
    ->controller(SignController::class)
    ->group(function() {

        Route::get('/','index');
        Route::get('/{sign}','show');

        Route::middleware(['auth:sanctum', 'ability:user-admin'])
            ->group(function() {

                Route::get('/{sign}/edit','edit');
                Route::post('/','store');
                Route::put('/{sign}','update');
                Route::delete('/{sign}','destroy');

            });
    });
