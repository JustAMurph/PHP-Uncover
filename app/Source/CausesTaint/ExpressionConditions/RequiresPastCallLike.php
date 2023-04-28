<?php

namespace App\Source\CausesTaint\ExpressionConditions;

use App\Parser\VariableContext;
use App\Signature\Signature;
use App\Source\CausesTaint\IExpressionCondition;
use App\Utility\CallLikeHelper;
use App\Utility\SearchAttribute;
use PhpParser\Node;
use PhpParser\Node\Expr;

class RequiresPastCallLike implements IExpressionCondition
{
    private Signature $signature;

    public function __construct(Signature $signature)
    {
        $this->signature = $signature;
    }

    public function isSourceExpression(Expr $expr, VariableContext $context = null): bool
    {
        // TODO: Implement isSourceExpression() method.
        $a =1;


        if ($expr instanceof Expr\Variable) {
            return $this->handleVariable($expr, $context);
        }

        if ($expr instanceof Expr\ArrayDimFetch) {
            return $this->handleArray($expr, $context);
        }



        $a=  1;


        return false;
    }

    private function handleArray(Expr\ArrayDimFetch $arrayDimFetch, VariableContext $context)
    {
        $localVar = $context->localVarByName($arrayDimFetch->var->name);

        return SearchAttribute::searchFrom($localVar->value, function(Node $node) {
                if (!$node instanceof Expr\CallLike) {
                    return;
                }

                return $this->signature->matches($node);
        });
    }

    private function handleVariable(Expr\Variable $variable, VariableContext $context)
    {

    }

}
