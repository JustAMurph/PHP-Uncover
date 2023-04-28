<?php

namespace App\Source\CausesTaint;

use App\Parser\VariableContext;
use App\Source\Metadata;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\Variable;

interface IIntroduceSourceByCallLike extends ICallLikeCondition
{
    public function createMetaFromCallLike(Variable $key, CallLike $callLike): Metadata;
    public function description(): string;
}
