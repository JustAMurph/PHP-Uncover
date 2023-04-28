<?php

namespace App\Source\CausesTaint;

use App\Parser\Instantiation;
use App\Parser\VariableContext;
use App\Signature\Signature;
use App\Source\Metadata;
use App\Utility\SearchAttribute;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\Variable;

class ArrayAccessAfterCallLike implements IIntroduceSourceByExpression
{
    private Signature $signature;
    private $type;

    public function __construct(Signature $methodCall)
    {
        $this->signature = $methodCall;
    }

    public function createMetaFromCallLike(Variable $key, CallLike $callLike): Metadata
    {
        return new Metadata('a', 'b');
    }

    public function description(): string
    {
        // TODO: Implement description() method.
    }

    public function isSourceExpression(Expr $expr, VariableContext $context = null): bool
    {

        if (!$expr instanceof Expr\ArrayDimFetch) {
            return false;
        }

        $localVariable = $context->localVarByName($callLike?->var?->name);
        if (!$localVariable) {
            return false;
        }

        if ($this->signature->matches($callLike)) {
            return SearchAttribute::searchFrom($localVariable->key, function(Node $node){
                if (!$node instanceof CallLike) {
                    return;
                }

                return $node->class->getFirst() == $this->type;
            });
        }

    }

    public function createMetaDataFromExpression(Variable $key, Expr $expr): Metadata
    {
        // TODO: Implement createMetaDataFromExpression() method.
    }
}
