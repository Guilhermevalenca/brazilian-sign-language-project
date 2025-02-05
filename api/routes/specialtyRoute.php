<?php

use App\Http\Controllers\SpecialtyController;
use Illuminate\Support\Facades\Route;

Route::prefix("specialtys")
    ->controller(SpecialtyController::class)
    ->whereNumber("specialty")
    ->group(function () {
        Route::get("", "index");
        Route::post("", "store");
        Route::get("{specialty}", "show");
        Route::put("{specialty}", "update");
        Route::delete("{specialty}", "destroy");
    });


?>
