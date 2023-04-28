<?php

namespace App\Providers;

use App\Events\AfterContextWalkerStatementEvent;
use App\Events\CheckVariableTaintEvent;
use App\Events\Http\ScanComplete;
use App\Events\LoadSinks;
use App\Events\LoadVulnerabilitiesEvent;
use App\Events\LocalAssignmentEvent;
use App\Events\NewLocalVariableEvent;
use App\Listeners\AssignmentTaintListener;
use App\Listeners\HandleNotificationsListener;
use App\Listeners\Notifications\CredentialsFoundListener;
use App\Listeners\Notifications\VulnerabilitiesFoundListener;
use App\Listeners\StandardVulnerabilityListener;
use App\Listeners\VulnerableCallLikeListener;
use App\Subscribers\TracePathwaySubscriber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AfterContextWalkerStatementEvent::class => [
        ],
        NewLocalVariableEvent::class => [
            AssignmentTaintListener::class
        ],
        LoadSinks::class => [
            StandardVulnerabilityListener::class
        ],
        // HTTP Based Events
        ScanComplete::class => [
            VulnerabilitiesFoundListener::class,
            CredentialsFoundListener::class,
            HandleNotificationsListener::class
        ]
    ];

    protected $subscribe = [
        TracePathwaySubscriber::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
