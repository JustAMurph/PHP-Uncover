<?php

namespace App\Plugins\Laravel;

use App\Config\ConfigFileCollection;
use App\Config\ILocateConfig;
use Symfony\Component\Finder\Finder;

class ConfigLocator implements ILocateConfig
{
    public function locate(\SplFileInfo $directory): ConfigFileCollection
    {
        return new ConfigFileCollection(
            (new Finder())
                ->path('config')
                ->notPath('vendor')
                ->name('*.php')
                ->in($directory->getPathname())
        );
    }
}
