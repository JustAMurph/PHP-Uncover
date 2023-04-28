<?php

namespace App\RouteParser;

interface IParseRoutes
{
    public function parse(\SplFileInfo $directory) : RouteCollection;
}
