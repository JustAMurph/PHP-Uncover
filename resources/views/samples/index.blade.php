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
                <li class="breadcrumb-item active" aria-current="page">Samples</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h2>Sample Source Code</h2>
                    <p>The below files are vulnerable web applications. These may be used to test out the scanning functionality.</p>

                    @include('samples/list')
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <a href="<?= route('dashboard') ?>" type="button" style="display:inline-block" class="btn btn-outline-secondary" >
            <i class="bi bi-chevron-double-left"></i> Back</a>
    </div>
</x-app-layout>
