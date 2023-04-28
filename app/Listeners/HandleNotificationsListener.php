<?php

namespace App\Listeners;

use App\Events\Http\ScanComplete;
use App\Mail\NotificationMail;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class HandleNotificationsListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(ScanComplete $event)
    {
        $expression = new ExpressionLanguage();
        $settings = $event->scan->application->organisation->notificationSettings;

        $counts = [
            'vulnerabilities' => $event->scan->vulnerabilities->count(),
            'credentials' => $event->scan->credentials->count(),
            'routes' => $event->scan->entrypoints->count()
        ];

        foreach($settings as $setting) {
            /**
             * @var NotificationSetting $setting
             */
            $result = $expression->evaluate($setting->evaluation, $counts);

            if ($result) {
                $this->notifyUser($setting->email, $event->scan, $setting->evaluation);
                $this->addCreatorNotification($event->scan, $event->user, $setting->evaluation);
            }
        }
    }

    private function addCreatorNotification(Scan $scan, User $user, $expression)
    {
        $notification = new Notification();
        $notification->read = false;
        $notification->message = sprintf(
            "%s has occurred in scan <a href='%s'>%d</a>",
            ucwords($expression),
            route('scans:view', ['id' => $scan->id]),
            $scan->id
        );

        $user->notifications()->save($notification);
    }

    private function notifyUser($email, Scan $scan, $expression)
    {
        Mail::to($email)->send(new NotificationMail($scan, $expression));
    }
}
