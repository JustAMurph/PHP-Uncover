<?php

namespace App\Events\Http;

use App\Analysis\Analysis;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScanComplete
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Scan $scan;
    public User $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Scan $scan, User $user)
    {
        $this->scan = $scan;
        $this->user = $user;
    }
}
