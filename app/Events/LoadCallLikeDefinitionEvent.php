<?php

namespace App\Events;

use App\Parser\VariableContext;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Expr\CallLike;

class LoadCallLikeDefinitionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CallLike $callLike;
    public VariableContext $context;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CallLike $callLike, VariableContext $context)
    {
        //
        $this->callLike = $callLike;
        $this->context = $context;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
