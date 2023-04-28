<?php

namespace App\Plugins\Contracts;

interface ISettingLocator
{
    public function locate(\SplFileInfo $directory, callable $filter = null);
}
