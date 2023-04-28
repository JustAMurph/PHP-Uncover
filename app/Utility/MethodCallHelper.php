<?php

namespace App\Utility;

use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;

class MethodCallHelper
{

    public static function getTrace($expr)
    {
        $result = collect();
        $result->push($expr->name->name);

        if ($expr->var instanceof PropertyFetch) {
            $r = static::getTrace($expr->var);
            $result = $r->merge($result);
        }

        if ($expr->var instanceof Variable) {
            $result->prepend($expr->var->name);
        }

        return $result;
    }
}
