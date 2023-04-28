<?php

/**
 * @var \App\Models\Application[] $applications
 * @var \App\Models\NotificationSetting[] $settings
 */
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notification Settings') }}
        </h2>
    </x-slot>

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Notifications Settings</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @if ($settings->isEmpty())
                        <p class="mb-0">No notifications are set. Please create one below.</p>
                    @else
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Comparison</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($settings as $setting)
                                <tr>
                                    <td scope="row">{{ $setting->id }}</td>
                                    <td>{{ $setting->email }}</td>
                                    <td>{{ ucwords($setting->evaluation) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('notificationSettings:delete') }}">
                                            @csrf
                                            <button type="submit" href="#" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <a href="<?= route('notificationSettings:create'); ?>" type="button" style="display:inline-block" class="btn btn-primary text-white">
        <i class="bi bi-plus"></i> Create Notification</a>
</x-app-layout>
