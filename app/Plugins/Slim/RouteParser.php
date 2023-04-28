<?php

namespace App\Plugins\Slim;

use App\RouteParser\BaseRouteParser;
use App\RouteParser\IParseRoutes;
use App\RouteParser\Route;
use App\RouteParser\RouteCollection;
use App\Utility\ArrayHelper;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\Finder\Finder;

class RouteParser extends BaseRouteParser implements IParseRoutes
{
    public function parse(\SplFileInfo $directory): RouteCollection
    {
        $files = collect((new Finder())
            ->files()
            ->path('app')
            ->name('routes.php')
            ->in($directory->getPathname()));

        $result = new RouteCollection();
        foreach ($files as $file) {
            $result = $result->merge($this->parseFile($file));
        }
        return $result;
    }

    public function parseFile(\SplFileInfo $file)
    {
        // TODO: Implement parse() method.
        $ast = AST::fromSplFile($file);

        $finder = resolve(EnhancedNodeFinder::class);
        /**
         * @var EnhancedNodeFinder $finder
         */

        $return = $finder->findTypeWithExpressionType($ast, Return_::class, Closure::class);
        return $this->recurse($return->expr->stmts);
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

                if ($methodName == 'group') {
                    $result = $result->merge(static::recurse(
                        $line->expr->args[1]->value->stmts,
                        $line->expr->args[0]->value->value
                    ));
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
        } else if ($mapping instanceof Closure) {
            return $mapping;
        } else if ($mapping instanceof ClassConstFetch && $mapping->name->name) {
                $controller = $mapping->class->getFirst();
                $action = 'action';
        }

        return $this->applicationDefinitions->findClassByNameAndMethod(
            $controller,
            $action
        );
    }
}
