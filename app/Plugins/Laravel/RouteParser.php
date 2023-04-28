<?php

namespace App\Plugins\Laravel;

use App\RouteParser\BaseRouteParser;
use App\RouteParser\IParseRoutes;
use App\RouteParser\Route;
use App\RouteParser\RouteCollection;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use Symfony\Component\Finder\Finder;

class RouteParser extends BaseRouteParser implements IParseRoutes
{
    public function parse(\SplFileInfo $directory): RouteCollection
    {

        $files = collect((new Finder())
            ->files()
            ->path('routes')
            ->notName(['console', 'channels'])
            ->name('web.php')
            ->in($directory->getPathname()));

        $result = new RouteCollection();
        foreach ($files as $file) {
            $result = $result->merge($this->parseFile($file));
        }
        return $result;
    }

    public function parseFile(\SplFileInfo $file)
    {
        return $this->recurse(AST::fromSplFile($file));
    }

    private function recurse($ast, $group = '')
    {
        $result = new RouteCollection();
        foreach($ast as $line) {
            if (!$line instanceof Expression) {
                continue;
            }

            if ($line->expr instanceof StaticCall) {
                if (in_array($line->expr->name->name, ['get', 'post'])) {
                    $ep = new Route(
                        $this->resolveController($line->expr->args[1]->value)
                    );

                    $url = $line->expr->args[0]->value->value;
                    if (!empty($group)) {
                        $url = $group . '/' . $url;
                    }
                    $ep->addUrl($url);
                    $result->push($ep);
                }

                if (in_array($line->expr->name->name, ['group'])) {
                    $result = $result->merge($this->recurse($line->expr->args[0]->value->stmts, $group . $line->expr->var->args[0]->value->value));
                }
            }

            if ($line->expr instanceof MethodCall) {
                $methodCall = $line->expr->var;
                if ($line->expr->var instanceof StaticCall) {
                    if ($methodCall->name->name == 'prefix') {
                        $result = $result->merge(
                            $this->recurse(
                                $line->expr->args[0]->value->stmts,
                                $group . $line->expr->var->args[0]->value->value
                            )
                        );
                    }

                    if ($methodCall->name->name == 'middleware') {
                        $result = $result->merge(
                            $this->recurse(
                                $line->expr->args[0]->value->stmts,
                                $group
                            )
                        );
                    }
                }
            }
        }
        return $result;
    }

    private function resolveController($mapping)
    {
        if ($mapping instanceof Closure) {
            return $mapping;
        }

        if ($mapping instanceof String_ && Str::contains($mapping->value, '@')) {
            $split = explode('@', $mapping->value);
            $r =  $this->applicationDefinitions->findClassByNameAndMethod($split[0], $split[1]);
            return $r;
        }
    }
}
