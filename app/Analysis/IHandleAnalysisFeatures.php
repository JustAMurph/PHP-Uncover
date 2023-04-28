<?php

namespace App\Analysis;

use App\Config\ConfigFileCollection;
use Illuminate\Support\Collection;

interface IHandleAnalysisFeatures
{
    public function entrypoints(Collection $entrypoints);
    public function credentials(ConfigFileCollection $credentials);
    public function settings(ConfigFileCollection $settings);
    public function routes(Collection $routes);
}
