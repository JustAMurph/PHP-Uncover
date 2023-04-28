<?php

namespace App\Config;

interface ILocateConfig
{
    public function locate(\SplFileInfo $directory) : ConfigFileCollection;
}
