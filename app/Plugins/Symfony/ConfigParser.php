<?php

namespace App\Plugins\Symfony;

use App\Config\IParseConfig;
use App\Config\VariableCollection;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

class ConfigParser implements IParseConfig
{
    public function parseFile(\SplFileInfo $config): VariableCollection
    {
        return new VariableCollection(Yaml::parseFile($config->getPathname()));
    }
}
