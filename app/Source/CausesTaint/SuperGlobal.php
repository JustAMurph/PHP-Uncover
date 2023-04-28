<?php

namespace App\Source\CausesTaint;

use App\Parser\VariableContext;
use App\Source\Metadata;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Variable;

class SuperGlobal implements IIntroduceSourceByExpression
{
    private $globals = [
        '_GET',
        '_POST',
        '_REQUEST',
        '_COOKIE'
    ];

    public function isSourceExpression(Expr $expr, VariableContext $context = null): bool
    {
        if ($expr instanceof Variable) {
            return $this->isTaintedVariable($expr);
        }

        if ($expr instanceof Expr\ArrayDimFetch) {
            return $this->isTaintedVariable($expr->var);
        }

        return false;
    }

    public function isTaintedVariable(Variable $variable)
    {
        return in_array($variable->name, $this->globals);
    }

    public function createMetaDataFromExpression(Variable $key, Expr $expr): Metadata
    {
        if ($expr instanceof Variable) {
            return new Metadata($expr->name, sprintf('$%s[%s]', $expr->name, $key->name));
        }
    }

    public function description(): string
    {
    }
}
