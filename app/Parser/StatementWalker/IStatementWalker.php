<?php

namespace App\Parser\StatementWalker;

use App\Parser\VariableContext;

interface IStatementWalker
{
    public function recurse(array $statements, VariableContext $context) : VariableContext;
}
