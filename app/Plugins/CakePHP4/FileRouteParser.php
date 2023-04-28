<?php

namespace App\Plugins\CakePHP4;

use App\RouteParser\BaseRouteParser;
use App\RouteParser\IParseRoutes;
use App\RouteParser\Route;
use App\RouteParser\RouteCollection;
use App\Utility\ArrayHelper;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use Symfony\Component\Finder\Finder;

class FileRouteParser extends BaseRouteParser implements IParseRoutes
{
    public function parse(\SplFileInfo $directory) : RouteCollection
    {

        $controllers = collect((new Finder())
            ->path('config')
            ->notPath(['vendor','tests'])
            ->files()
            ->name('routes.php')
            ->in($directory->getPathname()));

        $result = new RouteCollection();

        foreach($controllers as $controller) {
            $result = $result->merge($this->parseFile($controller));
        }

        return $result;
    }

    public function parseFile(\SplFileInfo $file) : RouteCollection
    {
        $ast = AST::fromSplFile($file);

        $finder = resolve(EnhancedNodeFinder::class);
        /**
         * @var EnhancedNodeFinder $finder
         */

        $routeBuilder = $finder->findFirstInstanceOf($ast, Closure::class);
        return $this->recurse($routeBuilder->stmts);
    }

    private function recurse($ast, $group = '') : RouteCollection
    {
        $result = new RouteCollection();

        foreach ($ast as $line) {
            if (!$line instanceof Expression) {
                continue;
            }

            if ($line->expr instanceof MethodCall) {
                $methodName = $line->expr->name->name;
                if ($methodName == 'scope') {
                    $result = $result->merge(static::recurse(
                        $line->expr->args[1]->value->stmts,
                        $line->expr->args[0]->value->value
                    ));
                }

                if ($methodName == 'connect') {
                    $result->push(
                        Route::withUrl(
                            $this->resolveController($line->expr->args[1]->value),
                            $this->cleanUrl($group . $line->expr->args[0]->value->value)
                        )
                    );
                }

                if (in_array($methodName, ['get', 'post', 'put', 'patch', 'delete', 'options', 'head'])) {
                    $result->push(
                        Route::withUrl(
                            $this->resolveController($line->expr->args[1]->value),
                            $this->cleanUrl($group . $line->expr->args[0]->value->value),
                            strtoupper($methodName)
                        )
                    );
                }
            }
        }

        return $result;
    }

    private function cleanUrl($url) {
        return Str::replace('//', '/', $url);
    }

    private function resolveController($mapping)
    {
        if ($mapping instanceof Array_) {
            $controller = ArrayHelper::findByKey($mapping, 'controller') . 'Controller';
            $action = ArrayHelper::findByKey($mapping, 'action');
        } else if ($mapping instanceof String_) {
            $split = explode('::', $mapping->value);
            $controller = $split[0] . 'Controller';
            $action = $split[1];
        }

        return $this->applicationDefinitions->findClassByNameAndMethod(
            $controller,
            $action
        );
    }

}
