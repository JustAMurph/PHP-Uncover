<?php

namespace App\Source\CausesTaint;

use App\Parser\Instantiation;
use App\Parser\VariableContext;
use App\Signature\Signature;
use App\Source\Metadata;
use App\Utility\SearchAttribute;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Variable;

class MethodCallOfType implements IIntroduceSourceByCallLike
{
    private Signature $signature;
    private $type;

    public function __construct(Signature $methodCall, $type)
    {
        $this->signature = $methodCall;
        $this->type = $type;
    }

    public function isSourceCallLike(Expr\CallLike $callLike, VariableContext $context = null): bool
    {
        if (!property_exists($callLike, 'var')) {
            return false;
        }

        $localVariable = $context->localVarByName($callLike?->var?->name);
        if (!$localVariable) {
            return false;
        }

        if ($this->signature->matches($callLike)) {
            if ($localVariable->value instanceof Instantiation) {
                return $localVariable->value->type == $this->type;
            } else {
                return SearchAttribute::searchFrom($localVariable->key, function(Node $node){
                    if (!$node instanceof Expr\New_) {
                        return;
                    }

                    return $node->class->getFirst() == $this->type;
                });
            }
        }

        return false;
    }

    public function createMetaFromCallLike(Variable $key, Expr\CallLike $callLike): Metadata
    {
        return new Metadata('a', 'b');
    }

    public function description(): string
    {
        // TODO: Implement description() method.
    }
}
