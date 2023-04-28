<?php

namespace App\Vulnerabilities\Definitions\Conditions;

use App\Parser\VariableContext;
use App\Signature\IMatchCallLike;
use App\Signature\Signature;
use App\Utility\SearchAttribute;
use PhpParser\Node;
use PhpParser\Node\Expr\CallLike;

class RequiresPastCallLike implements IMatchCallLike
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
        $localVar = $context->localVarByName($callLike->var->name);

        return SearchAttribute::searchFrom($localVar->key, function(Node $node) {
            if ($node instanceof CallLike) {
                return $this->signature->matches($node);
            }
        });
    }
}
