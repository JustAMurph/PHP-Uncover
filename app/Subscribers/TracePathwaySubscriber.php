<?php

namespace App\Subscribers;

use App\Events\LocalAssignmentEvent;
use App\Events\NewCallLikeContextEvent;
use App\Events\NewLocalVariableEvent;
use Illuminate\Events\Dispatcher;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;

class TracePathwaySubscriber
{

    public function handleLocalVariableEvent(NewLocalVariableEvent $event)
    {
        $event->keyValueVariable->key->setAttribute('from', $event->keyValueVariable->value);
    }

    public function handleCallLikeNewContext(NewCallLikeContextEvent $event)
    {
        $event->newVar->setAttribute('from', $event->callLike);
        $event->callLike->setAttribute('from', $event->oldVar);
        $event->callLike->setAttribute('definition', $event->funcDefinition);
    }

    public function subscribe(Dispatcher $events)
    {
        return [
            NewLocalVariableEvent::class => 'handleLocalVariableEvent',
            NewCallLikeContextEvent::class => 'handleCallLikeNewContext'
        ];
    }
}
