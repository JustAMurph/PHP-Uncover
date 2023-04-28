<?php
/**
 * @var \App\EntryPoint\EntryPoint[] $vulnerabilities
 * @var \App\Parser\StatementWalker\RouteCollection $entryPoints
 * @var \App\Config\ConfigFileCollection $credentials
 * @var \App\Config\ConfigFileCollection $settings
 */
?>
<header>
    <h1>PHPUncover: Analysis Report</h1>
</header>


<main>
    <div class="tabs">
        <ul>
            <li><a href="#" data-tab-show="#summary">Summary</a></li>

            @isset($vulnerabilities)
            <li><a href="#" data-tab-show="#vulnerabilities">Vulnerabilities</a></li>
            @endisset
            @isset($entryPoints)
            <li><a href="#" data-tab-show="#routes">Routes</a></li>
            @endisset
            @isset($settings)
            <li><a href="#" data-tab-show="#settings">Settings</a></li>
            @endisset
            @isset($credentials)
            <li><a href="#" data-tab-show="#credentials">Credentials</a></li>
            @endisset
        </ul>

        <div id="summary" class="tab-item" tab-default="true">
            <h2>Analysis Summary!</h2>

            <p>
                @isset($vulnerabilities)
                    <b>Vulnerabilities:</b> <?= $vulnerabilities->count(); ?> <br/>
                @endisset

                @isset($entryPoints)
                    <b>Routes:</b> <?= $entryPoints->count(); ?><br/>
                @endisset

                @isset($settings)
                    <b>Settings:</b> <?= $settings->count(); ?><br/>
                @endisset

                @isset($credentials)
                    <b>Credentials:</b> <?= $credentials->count(); ?>
                @endisset
            </p>
        </div>

        @isset($vulnerabilities)
            <div id="vulnerabilities" class="tab-item">
                <h2>Vulnerabilities</h2>


                @foreach($vulnerabilities as $vulnerability)

                    <div class="vulnerability">
                        <div class="vulnerability-title">
                            <h3>{{ $vulnerability->getVulnerableExecutionName() }}

                                <span class="vulnerability-severity vulnerability-severity-{{ strtolower($vulnerability->vulnerability->getSeverity()->value) }}">
                                    {{ $vulnerability->vulnerability->getSeverity()->value }}
                                </span>

                            </h3>
                        </div>

                        <div class="vulnerability-pathway">
                            <p>{{ $vulnerability->toExecutionPath() }}</p>
                        </div>

                        <div class="vulnerability-description">
                            <h5 class="vulnerability-subtitle">
                                Description:
                            </h5>
                            <p>{{ $vulnerability->vulnerability->getDescription() }}</p>
                        </div>



                        <div class="vulnerability-urls">
                            <h5 class="vulnerability-subtitle">
                                URLs:
                            </h5>
                            <p>
                                @foreach($vulnerability->route->getUrls() as $url)
                                    {{ $url }} <br/>
                                @endforeach
                            </p>
                        </div>

                        <div class="vulnerability-remediation">
                            <h5 class="vulnerability-subtitle">
                                Remediation:
                            </h5>
                            {{ $vulnerability->vulnerability->getRemediation() }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endisset

        @isset($entryPoints)
            <div id="routes" class="tab-item">
                <h2>Routes</h2>

                <?php foreach($entryPoints as $entryPoint): ?>
                    <?php foreach($entryPoint->getUrls() as $url): ?>
                        [{{ $entryPoint->getMethod() }}] - {{ $url }} <br/>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        @endisset

        @isset($credentials)
        <div id="credentials" class="tab-item">
            <h2>Credentials</h2>

            @include('output/settings', ['settings' => $credentials])
        </div>
        @endisset

        @isset($settings)
            <div id="settings" class="tab-item">
                <h2>Settings</h2>

                @include('output/settings', ['settings' => $settings])
            </div>
        @endisset
    </div>
</main>

<div id="scripts">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            var tabs_content = $('.tab-item');
            $('[tab-default]').addClass('tab-show');

            $('.tabs a').click(function(e) {
                e.preventDefault();
                link = $(this).data('tab-show');

                console.log('Acitivating link ', link);
                $('.tab-active').removeClass('tab-active');
                $(this).addClass('tab-active');

                tabs_content.filter(link).addClass('tab-show');
                tabs_content.not(link).removeClass('tab-show');
            })
        });
    </script>
</div>
</body>
</html>
