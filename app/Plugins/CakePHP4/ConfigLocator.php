<?php

namespace App\Plugins\CakePHP4;

use App\Config\ConfigFileCollection;
use App\Config\ILocateConfig;
use Symfony\Component\Finder\Finder;

class ConfigLocator implements ILocateConfig
{
    public function locate(\SplFileInfo $directory): ConfigFileCollection
    {
        return new ConfigFileCollection((new Finder())
            ->name('*.php')
            ->path('config')
            ->notPath('vendor')
            ->in($directory->getPathname()));
    }
}
