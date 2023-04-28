<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="row mb-3">
        <div class="col">
            <div class="card card-purple card-with-icon">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="bi bi-code-slash"></i>
                    </div>
                    <div class="card-number">
                        5
                    </div>
                    <div class="card-number-subtitle">
                        Applications
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-blue card-with-icon">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <div class="card-number">
                        45
                    </div>
                    <div class="card-number-subtitle">
                        Application Scans
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-green card-with-icon">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div class="card-number">
                        103
                    </div>
                    <div class="card-number-subtitle">
                        Logins
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-orange card-with-icon">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="bi bi-radioactive"></i>
                    </div>
                    <div class="card-number">
                        4
                    </div>
                    <div class="card-number-subtitle">
                        Vulnerabilities
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3>Vulnerabilities per application:</h3>

                    <canvas id="vulnsPerApp" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <!-- ... -->

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3>Vulnerabilities per month:</h3>

                    <canvas id="vulnsPerMonth" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">

            <div class="card">
                <div class="card-body">
                    <h3>Vulnerabilities per type:</h3>

                    <canvas id="vulnsPerType" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <!-- ... -->
        <div class="col ">
            <div class="card">
                <div class="card-body">
                    <h3>Vulnerabilities per application:</h3>

                    <canvas id="vulnsPerApplication" width="400" height="400"></canvas>
                </div>
        </div>
    </div>
</x-app-layout>
