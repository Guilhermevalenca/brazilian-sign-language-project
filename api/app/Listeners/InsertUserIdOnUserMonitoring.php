<?php

namespace App\Listeners;

use App\Events\UserMonitoring;
use App\Models\UserMonitoring as ModelsUserMonitoring;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InsertUserIdOnUserMonitoring
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserMonitoring $event): void
    {
        $userId = $event->userId;
        $token = $event->token;

        ModelsUserMonitoring::where('token', $token)->update(['user_id' => $userId]);
    }
}
