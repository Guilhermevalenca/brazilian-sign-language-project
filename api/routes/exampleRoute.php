<?php

use App\Http\Controllers\ExampleController;
use Illuminate\Support\Facades\Route;

Route::prefix('examples')
    ->controller(ExampleController::class)
    ->group(function() {

        Route::get('/{example}','show');

        Route::middleware(['auth:sanctum', 'ability:user-admin'])
            ->group(function() {

                Route::post('/','store');
                Route::put('/{example}','update');
                Route::delete('/{example}','destroy');

            });

    });
