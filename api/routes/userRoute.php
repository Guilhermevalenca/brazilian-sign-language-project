<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')
    ->controller(ProfileController::class)
    ->middleware('auth:sanctum')
    ->group(function() {

        Route::put('', 'update');
        Route::put('password', 'updatePassword');
        Route::delete('', 'destroy');

    });