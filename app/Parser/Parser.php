<?php

namespace App\Parser;

use App\ApplicationDefinitions\ApplicationDefinitions;
use App\EntryPoint\EntryPointCollection;
use App\Events\AfterContextWalkerStatementEvent;
use App\Events\LoadCallLikeDefinitionEvent;
use App\Listeners\FindCallLikeDefinitionListener;
use App\Listeners\VulnerableCallLikeListener;
use App\Listeners\VulnerableExpressionListener;
use App\Parser\StatementWalker\IStatementWalker;
use App\Parser\StatementWalker\SimpleStatementWalker;
use App\RouteParser\Route;
use App\RouteParser\RouteCollection;
use Illuminate\Support\Facades\Event;

class Parser
{
    private IStatementWalker $walker;

    public function __construct(IStatementWalker $walker)
    {
        $this->walker = $walker;
    }

    public function registerApplicationDefinition(ApplicationDefinitions $applicationDefinitions)
    {
        $listener = new FindCallLikeDefinitionListener($applicationDefinitions);
        Event::listen(LoadCallLikeDefinitionEvent::class, [$listener, 'handle']);
    }

    public function routeCollection(RouteCollection $collection) : EntryPointCollection
    {
        $results = new EntryPointCollection();

        foreach ($collection as $route) {
            $results = $results->merge($this->route($route));
        }

        return $results;
    }

    private function route(Route $route) : EntryPointCollection
    {
        if (!$route->getExpr()) {
            // Cannot find the associated statements / resolve the route.
            return new EntryPointCollection();
        }

        return $this->walk(
            VariableContext::fromRoute($route),
            $route->getExpr()->stmts
        );
    }

    private function walk(VariableContext $context, array $stmts) : EntryPointCollection
    {
        $vulnerableCallLikeListener = resolve(VulnerableCallLikeListener::class);
        Event::listen(AfterContextWalkerStatementEvent::class, [$vulnerableCallLikeListener, 'handle']);

        $vulnerableExpressionListener = (resolve(VulnerableExpressionListener::class));
        Event::listen(AfterContextWalkerStatementEvent::class, [$vulnerableExpressionListener, 'handle']);

        $this->walker->recurse($stmts, $context);

        $results = new EntryPointCollection();
        $results = $results->merge($vulnerableCallLikeListener->results);
        return $results->merge($vulnerableExpressionListener->results);
    }
}
