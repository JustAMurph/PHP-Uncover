<?php

namespace App\Source\CausesTaint;

use App\Parser\VariableContext;
use App\Source\Metadata;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\Variable;

class ConditionalCallLikeSource implements IIntroduceSourceByCallLike
{
    private array $conditions;

    public function __construct($conditions = []) {

        $this->conditions = $conditions;
    }

    public function isSourceCallLike(CallLike $callLike, VariableContext $context = null): bool
    {
        foreach ($this->conditions as $condition) {
            /**
             * @var ICallLikeCondition $condition
             */
            if (!$condition->isSourceCallLike($callLike, $context)) {
                return false;
            }
        }

        return true;
    }

    public function createMetaFromCallLike(Variable $key, CallLike $callLike): Metadata
    {
        return new Metadata('a', 'v');
    }

    public function description(): string
    {
        // TODO: Implement description() method.
    }
}
