<?php

namespace App\Plugins\CodeIgniter3;

use App\RouteParser\ControllerEntryPointMapping;
use App\RouteParser\IParseRoutes;
use App\RouteParser\RouteCollection;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\ClassMethod;
use Symfony\Component\Finder\Finder;

class ControllerRouteParser implements IParseRoutes
{

    use ControllerEntryPointMapping;

    public function parse(\SplFileInfo $directory): RouteCollection
    {
        $nodeFinder = new EnhancedNodeFinder();
        $result = new RouteCollection();

        $controllers = (new Finder())->files()
            ->name('*.php')
            ->path('application/controllers')
            ->in($directory->getPathname());

        foreach($controllers as $controller)
        {
            $ast = AST::fromFile($controller->getPathname());
            $methods = $nodeFinder->find($ast, $this->findPublicMethodsInControllers(...));

            $result = $result->merge(
                $this->entryPointsFromClassMethods($methods)
            );
        }

        return $result;
    }

    private function findPublicMethodsInControllers($node)
    {
        if (!$node instanceof ClassMethod) {
            return;
        }

        if ($node->isPrivate()) {
            return;
        }

        if (Str::startsWith($node->name->name, '_')) {
            return;
        }

        return true;
    }
}
