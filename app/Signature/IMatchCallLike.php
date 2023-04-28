<?php

namespace App\Signature;

use App\Parser\VariableContext;
use PhpParser\Node\Expr\CallLike;

interface IMatchCallLike
{
    public function matches(CallLike $callLike, VariableContext $context) : bool;
}
