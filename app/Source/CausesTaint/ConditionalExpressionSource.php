<?php

namespace App\Source\CausesTaint;

use App\Parser\VariableContext;
use App\Source\Metadata;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\Variable;

class ConditionalExpressionSource implements IIntroduceSourceByExpression
{
    private array $conditions;

    public function __construct($conditions = []) {

        $this->conditions = $conditions;
    }

    public function isSourceExpression(Expr $expr, VariableContext $context = null): bool
    {
        foreach ($this->conditions as $condition) {
            /**
             * @var IExpressionCondition $condition
             */
            if (!$condition->isSourceExpression($expr, $context)) {
                return false;
            }
        }

        return true;
    }

    public function createMetaDataFromExpression(Variable $key, Expr $expr): Metadata
    {
        // TODO: Implement createMetaDataFromExpression() method.
    }

    public function description(): string
    {
        // TODO: Implement description() method.
    }
}
