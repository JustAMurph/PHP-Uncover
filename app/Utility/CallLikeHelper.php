<?php

namespace App\Utility;

use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;

class CallLikeHelper
{
    public static function getTrace(CallLike $callLike)
    {
        if ($callLike instanceof MethodCall) {
            return MethodCallHelper::getTrace($callLike);
        }

        if ($callLike instanceof StaticCall) {
            return collect([$callLike->class->getFirst(), $callLike->name->name]);
        }

        if ($callLike instanceof FuncCall) {
            return collect($callLike->name->getFirst());
        }

        if ($callLike instanceof New_) {
            return collect(['new', $callLike->class->getFirst()]);
        }
    }
}
