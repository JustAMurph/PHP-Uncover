<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!-- Scripts -->
        <script src="{{ asset('js/vue.js') }}" defer></script>
        <script src="{{ asset('js/bootstrap.js') }}" defer></script>
        <script src="{{ asset('js/custom.js') }}" defer></script>
        <script src="{{ asset('js/chart.js') }}" defer></script>
    </head>
    <body>
    @if (\Illuminate\Support\Facades\Session::has('evaluation'))
        <div class="evaluation-survey">
            <div class="container">
                Please complete the survey when you are finished. <a href="https://forms.gle/Q67gd8eXgTFabhDB6" target="_blank">Open Survey</a>
            </div>
        </div>
    @endif


    <div class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="border-bottom page-heading mb-3">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            {{ $header }}
                        </div>
                    </div>
                </div>
            </header>


            @if(\Illuminate\Support\Facades\Session::has('info'))
                <div class="container">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> {{ \Illuminate\Support\Facades\Session::get('info') }}
                    </div>
                </div>
            @elseif(\Illuminate\Support\Facades\Session::has('error'))
                <div class="container">
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle"></i> {{ \Illuminate\Support\Facades\Session::get('error') }}
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main id="app" class="container">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
