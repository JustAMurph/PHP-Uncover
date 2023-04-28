<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Scan') }}
        </h2>
    </x-slot>


    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('scans') }}">Scans</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col">
            <form method="POST">
                @csrf

                <file-component :applications="{{ json_encode($applications) }}">
            </form>
        </div>
    </div>
</x-app-layout>
