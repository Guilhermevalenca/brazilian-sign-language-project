<?php


use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::prefix("topics")
    ->controller(TopicController::class)
    ->whereNumber("topic")
    ->group(function () {
        Route::get("", "index");
        Route::get("{topic}", "show");
        Route::post("", "store");
        Route::put("{topic}", "update");
        Route::delete("{topic}", "destroy");


    });

?>
