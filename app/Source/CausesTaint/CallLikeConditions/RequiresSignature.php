<?php

namespace App\Source\CausesTaint\CallLikeConditions;

use App\Parser\VariableContext;
use App\Signature\Signature;
use App\Source\CausesTaint\ICallLikeCondition;
use PhpParser\Node\Expr\CallLike;

class RequiresSignature implements ICallLikeCondition
{

    private Signature $signature;

    public function __construct(Signature $signature)
    {
        $this->signature = $signature;
    }

    public function isSourceCallLike(CallLike $callLike, VariableContext $context = null): bool
    {
        return $this->signature->matches($callLike);
    }
}
