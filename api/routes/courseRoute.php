<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('courses')
    ->controller(CourseController::class)
    ->group(function() {

        Route::get('/','index');
        Route::get('/{course}','show');

        //Route::middleware(['auth:sanctum', 'ability:user-admin'])
            //->group(function() {

                Route::post('/','store');
                Route::put('/{course}','update');
                Route::delete('/{course}','destroy');

            //});
    });
