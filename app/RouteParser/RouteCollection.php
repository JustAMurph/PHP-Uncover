<?php

namespace App\RouteParser;

use Illuminate\Support\Collection;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;

class RouteCollection extends Collection
{
    public function hasURL($url)
    {
        return $this->contains(function(Route $value, $key) use ($url) {
            return $value->hasURL($url);
        });
    }

    public function findSameDefinition($expr) {
        if (!$expr instanceof ClassMethod) {
            return;
        }

        return $this->first(function(Route $entrypoint, $key) use ($expr) {
                if ($entrypoint->getExpr() instanceof Expr\Closure) {
                    return false;
                }

                return $expr->name->name == $entrypoint->getExpr()->name->name &&
                    $expr->getAttribute('parent')->name->name == $entrypoint->getExpr()->getAttribute('parent')->name->name;
        });
    }

    public function mergeSimilar(RouteCollection $merge)
    {
        foreach($merge as $potential) {
            foreach($potential->getUrls() as $url) {
                if (!$this->hasURL($url)) {

                    if ($ep = $this->findSameDefinition($potential->getExpr())) {
                        $ep->addUrl($url);
                    } else {
                        $this->push($potential);
                    }
                }
            }
        }
    }
}
