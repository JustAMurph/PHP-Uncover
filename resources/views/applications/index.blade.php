<?php

/**
 * @var \App\Models\Application[] $applications
 */
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Applications') }}
        </h2>
    </x-slot>

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">My Applications</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    @if ($applications->isEmpty())
                        There are no applications. Create a new application below.
                    @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Id:</th>
                            <th scope="col">
                                Application Name
                            </th>
                            <th scope="col">
                                Last Scan
                            </th>
                            <th scope="col">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($applications as $application): ?>
                        <tr class="">
                            <td>
                                <?= $application->id; ?>
                            </td>
                            <td scope="row">
                                <?= $application->name; ?>
                            </td>
                            <td>
                                @if($application->scans->isNotEmpty())
                                    {{ $application->scans[0]->updated_at }} (<a target="_blank" href="{{ route('scans:view', ['id' => $application->scans[0]->id]) }}">Report</a>)
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('applications:delete', ['application' => $application->id]) }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash-fill"></i> Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div >
        <div >
            <a href="<?= url('/applications/create'); ?>" type="button" style="display:inline-block"
               class="btn btn-primary text-white">
                <i class="bi bi-plus"></i> Create Application</a>
        </div>
    </div>
</x-app-layout>
