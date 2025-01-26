<?php

use App\Http\Controllers\KnowAreaController;
use Illuminate\Support\Facades\Route;

Route::prefix('knowareas')
    ->controller(KnowAreaController::class)
    ->whereNumber('knowarea')
    ->group(function () {

        Route::get('', 'index');

    });


