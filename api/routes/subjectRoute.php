<?php

use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('subjects')
    ->controller(SubjectController::class)
    ->group(function () {

        Route::get('/', 'index');
        Route::get('/{subject}', 'show');

        Route::middleware(['auth:sanctum', 'ability:user-admin'])
            ->group(function () {

                Route::post('/', 'store');
                Route::put('/{subject}', 'update');
                Route::delete('/{subject}', 'destroy');

            });
    });
