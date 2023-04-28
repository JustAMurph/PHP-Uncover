<?php

namespace App\Source\CausesTaint\ExpressionConditions;

use App\Parser\VariableContext;
use App\Source\CausesTaint\IExpressionCondition;
use PhpParser\Node\Expr;

class IsArrayAccess implements IExpressionCondition
{

    public function isSourceExpression(Expr $expr, VariableContext $context = null): bool
    {
        return $expr instanceof Expr\ArrayDimFetch;
    }
}
