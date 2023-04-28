<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationSettingsController extends Controller
{

    public function index()
    {
        $settings = $this->organisation()
            ->notificationSettings()
            ->get();

        return view('notification-settings/index', compact('settings'));
    }

    public function create()
    {
        return view('notification-settings/create');
    }

    public function delete()
    {
        $setting = NotificationSetting::query()
            ->organisationOwned($this->organisation())->first();

        $setting->delete();

        return redirect(route('notificationSettings'))->with('error', 'Deleted settings!');
    }

    public function store(Request $request, User $user)
    {
        $evaluation = sprintf(
            "%s %s %d",
            $request->get('category'),
            $request->get('comparison'),
            $request->get('amount')
        );

        $settings = new NotificationSetting([
            'email' => $request->get('email'),
            'evaluation' => $evaluation
        ]);

        $this->organisation()->notificationSettings()->save($settings);

        return redirect(route('notificationSettings'));
    }
}
