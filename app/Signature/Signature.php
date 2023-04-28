<?php

namespace App\Signature;

use App\Parser\VariableContext;
use App\Utility\CallLikeHelper;
use App\Utility\Regex;
use PhpParser\Node\Expr\CallLike;

/**
 * Represents a signature for execution.
 *
 * $this->load->view()
 *
 * Would be represented as:
 *
 * ['this', 'load', 'view']
 *
 * Auth::loadUser()
 *
 * Would be represented as:
 *
 * ['Auth', 'loadUser']
 */
class Signature implements IMatchCallLike
{
    public array $signature;

    public function __construct(...$args)
    {
        $this->signature = $args;
    }

    public function matches(CallLike $callLike, VariableContext $context = null) : bool
    {
        $trace = CallLikeHelper::getTrace($callLike);
        if (!$trace) {

        }
        return Regex::compareArrays($this->signature, $trace->toArray());
    }
}
