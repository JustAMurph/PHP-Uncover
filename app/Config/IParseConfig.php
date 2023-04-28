<?php

namespace App\Config;

use Illuminate\Support\Collection;

interface IParseConfig
{
    public function parseFile(\SplFileInfo $config) : VariableCollection;
}
