<?php

namespace App\Events;

use App\Parser\VariableContext;
use App\Utility\Route;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContextWalkerStatementEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $statement;
    public VariableContext $context;
    public Route $entrypoint;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($statement, VariableContext $context)
    {
        //
        $this->statement = $statement;
        $this->context = $context;
    }
}
