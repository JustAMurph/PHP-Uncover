<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Session;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Notification::userOwned($this->user())
            ->orderBy('id', 'desc')
            ->get();

        return view('notifications/index', ['notifications' => $notifications]);
    }

    public function read(Notification $notification)
    {
        if ($notification->isOwnedByUser($this->user())) {
            $notification->update(['read' => true]);
            Session::flash('info', 'Notification marked as read!');
        } else {
            Session::flash('error', 'You cannot alter this notification');
        }

        return redirect(route('notifications'));
    }
}
