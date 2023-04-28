<?php

namespace App\Source\CausesTaint;

use App\Parser\VariableContext;
use PhpParser\Node\Expr\CallLike;

interface ICallLikeCondition
{
    public function isSourceCallLike(CallLike $callLike, VariableContext $context = null): bool;
}
