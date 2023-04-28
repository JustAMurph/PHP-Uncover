<?php

namespace App\Plugins\Contracts;

use App\ApplicationDefinitions\ApplicationDefinitions;

interface IActAsPlugin
{
    public function getEntryPointLocator(): IRouteLocator;
    public function getDefinitionHandler(): ApplicationDefinitions;
    public function getSettingLocator(): ISettingLocator;
}
