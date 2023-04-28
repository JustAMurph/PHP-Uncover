<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;

class NewCallLikeContextEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CallLike $callLike;
    public Variable $oldVar;
    public Variable $newVar;
    public FunctionLike $funcDefinition;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CallLike $callLike, FunctionLike $funcDefinition, Variable $oldVar, Variable $newVar)
    {
        //
        $this->callLike = $callLike;
        $this->oldVar = $oldVar;
        $this->newVar = $newVar;
        $this->funcDefinition = $funcDefinition;
    }
}
