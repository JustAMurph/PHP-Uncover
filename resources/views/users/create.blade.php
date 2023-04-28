<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('users:store') }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-body">
                @include('partials/user-create')
            </div>
        </div>

        <div>
            <a href="{{ route('users') }}" class="btn btn-outline-secondary"><i class="bi bi-chevron-double-left"></i> Back</a>
            <button type="submit" class="btn btn-primary text-white"><i class="bi bi-plus"></i> Create</button>
        </div>
    </form>

</x-app-layout>
