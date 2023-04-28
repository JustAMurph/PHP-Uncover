<?php

namespace App\Signature;

use PhpParser\Node\Expr\StaticCall;

class Conditions
{
    public static function staticClassCall($class, $method)
    {
        return function($node) use ($class, $method) {
            if (!$node instanceof StaticCall) {
                return false;
            }

            return $node->class->getFirst() == $class && $node->name->name == $method;
        };
    }
}
