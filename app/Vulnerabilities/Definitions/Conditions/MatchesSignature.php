<?php

namespace App\Vulnerabilities\Definitions\Conditions;

use App\Parser\VariableContext;
use App\Signature\IMatchCallLike;
use App\Signature\Signature;
use PhpParser\Node\Expr\CallLike;

class MatchesSignature implements IMatchCallLike
{
    private Signature $signature;

    /**
     * @param Signature $signature
     */
    public function __construct(Signature $signature)
    {
        $this->signature = $signature;
    }

    public function matches(CallLike $callLike, VariableContext $context): bool
    {
        return $this->signature->matches($callLike);
    }
}
