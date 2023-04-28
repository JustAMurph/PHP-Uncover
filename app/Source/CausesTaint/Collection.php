<?php

namespace App\Source\CausesTaint;

use App\Parser\VariableContext;
use PhpParser\Node\Expr;

class Collection extends \Illuminate\Support\Collection
{
    public function byType($class)
    {
        return $this->filter(function($v, $k) use ($class) {
            return is_a($v, $class);
        });
    }

    public function isSourceExpression(Expr $expr, VariableContext $context = null): bool
    {
        return (bool) $this->getSourceFromExpression($expr, $context);
    }

    public function getSourceFromExpression(Expr $expr, VariableContext $context = null) : IIntroduceSourceByExpression | null
    {
        return $this->byType(IIntroduceSourceByExpression::class)
            ->first(function(IIntroduceSourceByExpression $source, $key) use ($expr, $context) {
            return $source->isSourceExpression($expr, $context);
        });
    }

    public function isSourceCallLike(Expr\CallLike $callLike, VariableContext $context = null): bool
    {
        return (bool) $this->getSourceFromCallLike($callLike, $context);
    }

    public function getSourceFromCallLike(Expr\CallLike $callLike, VariableContext $context = null): IIntroduceSourceByCallLike | null
    {
        return $this->byType(IIntroduceSourceByCallLike::class)->first(function(IIntroduceSourceByCallLike $source, $key) use ($callLike, $context) {
            return $source->isSourceCallLike($callLike, $context);
        });
    }
}
