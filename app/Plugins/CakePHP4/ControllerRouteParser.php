<?php

namespace App\Plugins\CakePHP4;

use App\RouteParser\ControllerEntryPointMapping;
use App\RouteParser\IParseRoutes;
use App\RouteParser\RouteCollection;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use PhpParser\Node\Stmt\ClassMethod;
use Symfony\Component\Finder\Finder;

class ControllerRouteParser implements IParseRoutes
{
    use ControllerEntryPointMapping;

    private $lifeCycle = [
        'initialize',
        'beforeFilter',
        'beforeRender',
        'afterFilter'
    ];

    public function parse(\SplFileInfo $directory): RouteCollection
    {
        $controllers = (new Finder())
            ->path('Controller')
            ->notPath(['vendor','tests'])
            ->files()
            ->name('*.php')
            ->in($directory->getPathname());

        $finder = new EnhancedNodeFinder();

        $result = new RouteCollection();

        foreach($controllers as $controller) {
            $methods = collect($finder->findPublicClassMethods(
                AST::fromFile($controller->getPathname())
            ));

            $methods = $methods->filter($this->filterControllerMethods(...));

            $result = $result->merge(
                $this->entryPointsFromClassMethods($methods)
            );
        }

        return $result;
    }

    private function filterControllerMethods(ClassMethod $method)
    {
        if (in_array($method->name->name, $this->lifeCycle)) {
            return false;
        }

        return true;
    }
}
