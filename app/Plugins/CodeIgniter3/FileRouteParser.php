<?php

namespace App\Plugins\CodeIgniter3;

use App\RouteParser\BaseRouteParser;
use App\RouteParser\IParseRoutes;
use App\RouteParser\Route;
use App\RouteParser\RouteCollection;
use App\Utility\EnhancedNodeFinder;
use Symfony\Component\Finder\Finder;

class FileRouteParser extends BaseRouteParser implements IParseRoutes
{
    private $reservedRoutes = ['404_override', 'translate_uri_dashes'];

    public function parse(\SplFileInfo $directory): RouteCollection
    {
        $routes = (new Finder())
            ->path('application/config')
            ->name('routes.php')
            ->in($directory->getPathname());

        $result = new RouteCollection();

        foreach($routes as $route) {
            $result = $result->merge($this->parseFile($route));
        }

        return $result;
    }

    private function parseFile(\SplFileInfo $file) {
        $settings = new ConfigParser();
        $routes = $settings->parseFile($file);

        $result = new RouteCollection();
        foreach($routes->get('route') as $route => $mapping)
        {
            if (in_array($route, $this->reservedRoutes)) {
                continue;
            }

            [$controller, $method] = $this->splitMapping($mapping);
            $definition = $this->applicationDefinitions->findClassByNameAndMethod($controller, $method);

            if ($definition) {
                $ep = new Route($definition);

                if ($route == 'default_controller') {
                    $ep->addUrl('/');
                } else {
                    $ep->addUrl($route);
                }

                $result->push($ep);
            }
        }

        return $result;
    }

    private function splitMapping($mapping)
    {
        $mapping = explode('/', $mapping);

        if (count($mapping) == 1) {
            return [ucwords($mapping[0]), 'index'];
        }

        return [ucfirst($mapping[0]), $mapping[1]];
    }
}
