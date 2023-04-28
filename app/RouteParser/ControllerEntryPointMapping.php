<?php

namespace App\RouteParser;

use Illuminate\Support\Str;
use PhpParser\Node\Stmt\ClassMethod;

/**
 * Represents mappings from a public controller to a URL.
 */
trait ControllerEntryPointMapping
{
    private function URLFromClassMethod($method)
    {
        $parent = $method->getAttribute('parent');
        return strtolower(Str::replace('controller', '', $parent->name->name) . '/' . $method->name->name);
    }

    private function entryPointFromClassMethod(ClassMethod $classMethod)
    {
        $ep = new Route($classMethod);

        if ($classMethod->name->name == 'index') {
            $ep->addUrl('/');
        }

        $ep->addUrl($this->URLFromClassMethod($classMethod));
        return $ep;
    }

    private function entryPointsFromClassMethods($arr): RouteCollection
    {
        $result = new RouteCollection();
        foreach($arr as $item) {
            $result->push($this->entryPointFromClassMethod($item));
        }
        return $result;
    }
}
