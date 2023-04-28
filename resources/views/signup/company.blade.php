<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <x-slot name="outside_card">
            <a href="{{ route('login') }}">Back to Login</a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('signup:details') }}">
        @csrf

        <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Company Name:')" />
                <x-input id="email" class="block mt-1 w-full" type="text" name="company" :value="old('email')" required autofocus autofill="false"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    {{ __('Next') }} <i class="bi bi-chevron-double-right"></i>
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
