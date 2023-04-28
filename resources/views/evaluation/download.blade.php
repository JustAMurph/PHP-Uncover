<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <x-slot name="outside_card">
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <h1>Test File Download</h1>

       <p> Choose a test case web application to download. This will be used
        later in the scanning process. Please choose the framework most applicable to your work.</p>

        @include('samples/list')

        <p>Once you have downloaded your test case. Please click the below button. A new account will be generated
        and you will have immediate access to the application.</p>

        <a href="{{ route('evaluation:login') }}" class="btn btn-primary text-white">Login to Portal</a>
    </x-auth-card>
</x-guest-layout>
