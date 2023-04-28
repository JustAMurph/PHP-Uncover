<?php

namespace App\Plugins\Slim;

use App\Config\ConfigFileCollection;
use App\Config\ILocateConfig;
use Symfony\Component\Finder\Finder;

class ConfigLocator implements ILocateConfig
{
    public function locate(\SplFileInfo $directory): ConfigFileCollection
    {
        return new ConfigFileCollection((new Finder())
            ->path('app')
            ->name('settings.php')
            ->in($directory->getRealPath()));
    }
}
