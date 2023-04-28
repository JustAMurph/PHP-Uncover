<?php

namespace App\Plugins\Contracts;

use App\RouteParser\RouteCollection;

interface IRouteLocator
{
    public function fromDirectory(\SplFileInfo $directory): RouteCollection;
}
