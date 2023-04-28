<?php

namespace App\Utility;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt;

class ExpressionHelper
{
    public static function getCallLike(Stmt\Expression $expression) : ?CallLike
    {
        if ($expression->expr instanceof CallLike) {
            $return = $expression->expr;
        }

        if ($expression->expr instanceof Assign)
        {
            if ($expression->expr->expr instanceof CallLike) {
                $return = $expression->expr->expr;
            }
        }

        if (empty($return)) {
            return null;
        }

        if ($return instanceof FuncCall or $return instanceof MethodCall or $return instanceof StaticCall) {
            return $return;
        }

        return null;
    }

    /**
     *
     * @todo Add other types as needed.
     *
     * @param Expr $expr
     * @return string|void
     */
    public static function friendlyName(Expr $expr)
    {
        $type = $expr->getType();

        switch($type) {
            case 'Expr_Include':
                return 'Include';
            case 'Expr_StaticCall':
            case 'Expr_MethodCall':
                return $expr->name->toString();
            case 'Expr_FuncCall':
                return $expr->name->toCodeString();
        }
    }

    public static function taint(Expr $expr)
    {
        $expr->setAttribute('tainted', true);
    }
}
