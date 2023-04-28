<?php

namespace App\Listeners\Notifications;

use App\Events\Http\ScanComplete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CredentialsFoundListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ScanComplete $event
     * @return void
     */
    public function handle(ScanComplete $event)
    {
        if ($event->scan->credentials->isEmpty()) {
            return;
        }

        // Send Emails
    }
}
