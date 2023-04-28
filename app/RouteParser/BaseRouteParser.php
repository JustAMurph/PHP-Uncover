<?php

namespace App\RouteParser;

use App\ApplicationDefinitions\ApplicationDefinitions;

class BaseRouteParser
{
    protected ?ApplicationDefinitions $applicationDefinitions;

    public function __construct(ApplicationDefinitions $applicationDefinitions)
    {
        $this->applicationDefinitions = $applicationDefinitions;
    }
}
