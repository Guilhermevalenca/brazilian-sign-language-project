<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__ . '/auth.php';
require __DIR__ . '/keywordsRoute.php';
require __DIR__ . '/knowAreasRoute.php';
require __DIR__ . '/specialtyRoute.php';
require __DIR__ . '/topicRoute.php';
