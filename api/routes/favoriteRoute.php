<?php


use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::prefix('favorites')
    ->controller(FavoriteController::class)
    ->middleware('auth:sanctum')
    ->group(function() {

        Route::get('/','index');
        Route::post('/','store');
        Route::delete('/{favorite}','destroy');

    });
