<?php

namespace App\Source\CausesTaint\CallLikeConditions;

use App\Parser\Instantiation;
use App\Parser\VariableContext;
use App\Source\CausesTaint\ICallLikeCondition;
use App\Source\CausesTaint\IIntroduceSourceByCallLike;
use App\Utility\SearchAttribute;
use PhpParser\Node;
use PhpParser\Node\Expr\CallLike;

class RequiresPastType implements ICallLikeCondition
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function isSourceCallLike(CallLike $callLike, VariableContext $context = null): bool
    {
        if ($callLike->var instanceof Node\Expr\PropertyFetch) {
            $name = $callLike->var->var->name;
        } else if($callLike->var instanceof Node\Expr\Variable) {
            $name = $callLike->var->name;
        }

        $localVariable = $context->localVarByName($name);
        if (!$localVariable) {
            return false;
        }

        if ($localVariable->value instanceof Instantiation) {
            return $localVariable->value->type == $this->type;
        } else {
            return SearchAttribute::searchFrom($localVariable->key, function(Node $node){
                if (!$node instanceof Node\Expr\New_) {
                    return false;
                }

                return $node->class->getFirst() == $this->type;
            });
        }
    }
}
