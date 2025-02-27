<?php

use App\Http\Controllers\auth\VerificationMailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthenticationController;

Route::prefix('users')
    ->group(function() {

        Route::controller(AuthenticationController::class)
            ->group(function () {

                Route::post('/login','login');
                Route::post('/register','register');

                Route::middleware('auth:sanctum')
                    ->group(function () {

                        Route::get('','me');
                        Route::get('/refresh','refresh');
                        Route::post('/logout','logout');

                    });
            });

        Route::controller(VerificationMailController::class)
            ->middleware('auth:sanctum')
            ->group(function() {

                Route::get('/send-verification-code','sendVerificationCode');
                Route::post('/verify-code','verifyCode');

            });

    });
