<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserMonitoringRequest;
use App\Http\Requests\UpdateUserMonitoringRequest;
use App\Models\UserMonitoring;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class UserMonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $avgPartOfPage = UserMonitoring::select(DB::raw('part_of_page, count(*) as count'))
            ->groupBy('part_of_page')
            ->orderBy('count', 'desc')
            ->get();

//        $averageDuration = UserMonitoring::calculateAverageUsageByPartOfPage();

        return response([
            'avgPartOfPage' => $avgPartOfPage,
//            'averageDuration' => $averageDuration
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserMonitoringRequest $request)
    {
        $secret = env('APP_KEY', 'plmnop');
        $validated = $request->validated();
        $token = $validated['token'] ?? null;

        $segments = explode('/', $validated['part_of_page']);
        if ($segments[0] == '') {
            $validated['part_of_page'] = $segments[1];
            $validated['reference_id'] = $segments[2] ?? null;
        } else {
            $validated['part_of_page'] = $segments[0];
            $validated['reference_id'] = $segments[1] ?? null;
        }

        $accessToken = $request->bearerToken();
        if ($accessToken) {
            $tokenModel = PersonalAccessToken::findToken($accessToken);
            if ($tokenModel) {
                Auth::login($tokenModel->tokenable);
            }
        }

        if (!Auth::check()) {
            if (!isset($validated['token'])) {
                $token = hash_hmac('sha256', $validated['timestamp'], $secret);
                $validated['token'] = $token;
            }
        } else {
            $validated['user_id'] = Auth::id();
            if (isset($token)) {
                event(new \App\Events\UserMonitoring($validated['user_id'], $token));
            }
        }

        UserMonitoring::create($validated);

        return response()->json([
            'token' => $token,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserMonitoring $userMonitoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserMonitoring $userMonitoring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserMonitoringRequest $request, UserMonitoring $userMonitoring)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserMonitoring $userMonitoring)
    {
        //
    }
}
