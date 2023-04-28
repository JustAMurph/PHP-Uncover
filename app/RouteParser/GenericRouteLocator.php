<?php

namespace App\RouteParser;

use App\Plugins\Contracts\IRouteLocator;

class GenericRouteLocator implements IRouteLocator
{
    /**
     * @var IParseRoutes[] $parsers
     */
    private $parsers;

    public function __construct($parsers)
    {
        $this->parsers = $parsers;
    }

    public function fromDirectory($directory): RouteCollection
    {
        $entryPoints = new RouteCollection();

        foreach($this->parsers as $parser) {
            $entryPoints->mergeSimilar($parser->parse($directory));
        }

        return $entryPoints;
    }
}
