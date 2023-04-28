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

        <h1>Evaluation</h1>
        <hr/>
        <p>Thank you for choosing to take part in this evaluation of PHPUncover for my MSc. in CyberSecurity.</p>

        <h3>What is PHPUncover?</h3>
        <p>
            PHPUncover is a static analyser for PHP source code. It searches source code for credentials,
        settings, routes and vulnerabilities. The underlying scanning algorithm aims to reduce false
            positives and increase true positives by adding framework specific knowledge to the scanner.
        </p>
        <p>The application attempts to parse all source code into an Abstract Syntax Tree (AST), find all routes, and then walks through the code detecting
        sources, sinks and vulnerabilities. It does not pattern match through Regex's instead it aims to understand the source code.</p>
        <p>There is both a CLI version and a web version of the tool. In this evaluation you will be asked to review the application
        through the web version.</p>

        <h3>Who is PHPUncover aimed at?</h3>
        <p>The aim is to allow penetration testers to quickly find sources of vulnerabilities, credentials, routes and settings
        in order to assist in the static code review process.</p>

        <p>A secondary market of source code reviewers, security engineers, and other cybersecurity personel has been
        identified. These roles may use the tool to gain a similar view to penetration testers.</p>

        <h3>What am I Evaluating?</h3>
        <p>The primary focus should be on the scan report. Have a look at the vulnerabilities it reports, the settings and the routes.
            A secondary focus can be placed on the Web UI and various features. However, any feedback is greatly appreciated.</p>

        <h3>... But I don't have any source code to evaluate!</h3>
        <p>The next page will allow you to download sample vulnerable applications to scan.</p>

        <h3>... But I don't want to create an account!</h3>
        <p>When following through this evaluation form an anonymous account will be created for you.</p>

        <hr/>
        <p>
            When you are finished I would be immensely grateful if you could fill in this Google forms questionnaire. No
            sign in is required.

            <a href="https://forms.gle/Q67gd8eXgTFabhDB6" target="_blank">Open survey in new tab</a>

            The whole process should only take around 10-15 minutes.
        </p>
        <p>Click below to get started.</p>


        <a href="{{ route('evaluation:download') }}" class="btn btn-primary text-white">Get Started</a>
    </x-auth-card>
</x-guest-layout>
