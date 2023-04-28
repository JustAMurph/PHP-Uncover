<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Application') }}
        </h2>
    </x-slot>

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('applications') }}">Applications</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>

    <form method="POST" action="{{ route('applications:create') }}">
        @csrf
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label for="applicationName" class="form-label">Application Name:</label>
                    <input type="text" class="form-control" id="applicationName" aria-describedby="emailHelp" name="name">
                    <div id="emailHelp" class="form-text">The display name of the application.</div>
                </div>
            </div>
        </div>

        <div>
            <a href="{{ route('applications') }}" class="btn btn-outline-secondary"><i class="bi bi-chevron-double-left"></i> Back</a>
            <button class="btn btn-primary text-white" type="submit"><i class="bi bi-plus"></i> Create</button>
        </div>
    </form>

</x-app-layout>
