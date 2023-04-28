<?php

namespace App\Events;

use App\Parser\KeyValueVariable;
use App\Parser\VariableContext;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewLocalVariableEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public KeyValueVariable $keyValueVariable;
    public VariableContext $context;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(KeyValueVariable $keyValueVariable, VariableContext $context)
    {
        $this->keyValueVariable = $keyValueVariable;
        $this->context = $context;
    }
}
