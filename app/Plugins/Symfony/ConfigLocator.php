<?php

namespace App\Plugins\Symfony;

use App\Config\ConfigFileCollection;
use App\Config\ILocateConfig;
use Symfony\Component\Finder\Finder;

class ConfigLocator implements ILocateConfig
{
    public function locate(\SplFileInfo $directory): ConfigFileCollection
    {
        return new ConfigFileCollection((new Finder())
            ->files()
            ->name('*.yaml')
            ->path('config')
            ->notPath('vendor')
            ->in($directory->getPathname()));
    }
}
