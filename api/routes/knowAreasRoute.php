<?php

use App\Http\Controllers\KnowAreaController;
use Illuminate\Support\Facades\Route;

Route::prefix('knowareas')
    ->controller(KnowAreaController::class)
    ->whereNumber('knowArea')
    ->group(function () {

        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('{knowArea}', 'show');
        Route::put('{knowArea}', 'update');
        Route::delete('{knowArea}', 'destroy');
    });


