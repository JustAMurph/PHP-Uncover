<?php

namespace App\Listeners;

use App\ApplicationDefinitions\ApplicationDefinitions;
use App\Events\LoadCallLikeDefinitionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FindCallLikeDefinitionListener
{
    private ApplicationDefinitions $applicationDefinitions;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ApplicationDefinitions $applicationDefinitions)
    {
        $this->applicationDefinitions = $applicationDefinitions;
    }

    /**
     * Handle the event.
     *
     * @param LoadCallLikeDefinitionEvent $event
     * @return void
     */
    public function handle(LoadCallLikeDefinitionEvent $event)
    {
        return $this->applicationDefinitions->getCallLikeDefinition($event->callLike, $event->context);
    }
}
