<?php

use App\Http\Controllers\KnowAreaController;
use Illuminate\Support\Facades\Route;

Route::prefix('knowareas')
    ->controller(KnowAreaController::class)
    ->group(function() {

        Route::get('/','index');
        Route::get('/{knowArea}','show');

        //Route::middleware(['auth:sanctum', 'ability:user-admin'])
            //->group(function() {

                Route::post('/','store');
                Route::put('/{knowArea}','update');
                Route::delete('/{knowArea}','destroy');

           // });
    });
