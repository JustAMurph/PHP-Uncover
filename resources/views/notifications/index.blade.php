<?php
/**
 * @var \App\Models\Notification[] $notifications
 */
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alerts') }}
        </h2>
    </x-slot>

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Alerts</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    @if($notifications->isEmpty())
                        <p class="mb-0">You have no alerts.</p>
                    @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">
                                ID:
                            </th>
                            <th scope="col">
                                Message:
                            </th>

                            <th scope="col">
                                Read?
                            </th>
                            <th scope="col">
                                Actions:
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($notifications as $notification)
                            <tr>
                                <td>{{ $notification->id }}</td>
                                <td>{!! strip_tags($notification->message, '<a><p>') !!}</td>
                                <td>
                                    @if ($notification->read)
                                        <i class="bi bi-check2-all"></i>
                                    @else
                                        <i class="bi bi-x-lg"></i>
                                    @endif</td>
                                <td>
                                    @if(!$notification->read)
                                        <form method="POST" action="{{ route('notifications:read', ['notification' => $notification->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="bi bi-check-all"></i> Read</button>
                                        </form>
                                    @else
                                        N/A
                                    @endif
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

    <div class="">
        <a href="<?= route('dashboard') ?>" type="button" style="display:inline-block" class="btn btn-outline-secondary" >
            <i class="bi bi-chevron-double-left"></i> Back</a>
    </div>
</x-app-layout>
