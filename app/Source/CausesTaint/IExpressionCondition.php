<?php

namespace App\Source\CausesTaint;

use App\Parser\VariableContext;
use PhpParser\Node\Expr;

interface IExpressionCondition
{
    public function isSourceExpression(Expr $expr, VariableContext $context = null): bool;
}
