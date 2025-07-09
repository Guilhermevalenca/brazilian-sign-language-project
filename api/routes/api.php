<?php

use App\Models\UserMonitoring;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('testando', function (Request $request) {
    $response = DB::table(
        DB::raw('(SELECT part_of_page, DATE(timestamp) as date, COUNT(*) as daily_count
              FROM user_monitorings
              GROUP BY part_of_page, DATE(timestamp)) as daily_counts')
    )
        ->select('part_of_page', DB::raw('AVG(daily_count) as average_daily'))
        ->groupBy('part_of_page')
        ->get();
    return response($response, 200);
});

require __DIR__ . '/authRoute.php';
require __DIR__ . '/signRoute.php';
require __DIR__ . '/descriptionRoute.php';
require __DIR__ . '/exampleRoute.php';
require __DIR__ . '/favoriteRoute.php';
require __DIR__ . '/subjectRoute.php';
require __DIR__ . '/courseRoute.php';
require __DIR__ . '/keywordRoute.php';
require __DIR__ . '/userRoute.php';
require __DIR__ . '/userMonitoring.php';
