<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scans') }}
        </h2>
    </x-slot>

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Scans</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    @if ($scans->isEmpty())
                        <p class="mb-0">There are no scans available. Please click 'Create Scan' below.</p>
                    @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">
                                ID:
                            </th>
                            <th scope="col">
                                Application:
                            </th>
                            <th scope="col">
                                Created
                            </th>

                            <th scope="col">
                                Finished
                            </th>
                            <th scope="col">
                                Vulnerabilities
                            </th>
                            <th scope="col">
                                Credentials
                            </th>
                            <th scope="col">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($scans as $scan)
                            <tr class="">
                                <td scope="row">
                                    {{ $scan->id }}
                                </td>
                                <td>
                                    {{ $scan->application->name }}
                                </td>
                                <td>
                                    {{ $scan->created_at }}
                                </td>
                                <td>
                                    {{ $scan->updated_at }}
                                </td>
                                <td>
                                    @if ($scan->vulnerabilities)
                                        {{ $scan->vulnerabilities->count() }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if ($scan->credentials)
                                        {{ $scan->credentials->count() }}
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td >
                                    <a href="{{ route('scans:view', ['id' => $scan->id]) }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-pdf"></i> View Report</a>
                                    <a href="{{ route('scans:delete', ['id' => $scan->id]) }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i> Delete</a>
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
        <a href="<?= url('/scans/create'); ?>" type="button" style="display:inline-block" class="btn btn-primary text-white" >
            <i class="bi bi-plus"></i> Create Scan</a>
    </div>
</x-app-layout>
