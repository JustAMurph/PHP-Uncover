<?php

namespace App\Source\CausesTaint;

use App\Parser\VariableContext;
use App\Source\Metadata;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Variable;

interface IIntroduceSourceByExpression extends IExpressionCondition
{
    public function createMetaDataFromExpression(Variable $key, Expr $expr): Metadata;
    public function description(): string;
}
