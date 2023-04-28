<?php

namespace App\Parser\StatementWalker;

use App\Events\AfterContextWalkerStatementEvent;
use App\Events\BeforeContextWalkerStatementEvent;
use App\Events\LoadCallLikeDefinitionEvent;
use App\Parser\VariableContext;
use App\Utility\ExpressionHelper;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\If_;

class SimpleStatementWalker implements IStatementWalker
{
    public function recurse(array $statements, VariableContext $context) : VariableContext
    {
        foreach($statements as $statement)
        {
            BeforeContextWalkerStatementEvent::dispatch($statement, $context);
            $this->{$statement->getType()}($statement, $context);
            AfterContextWalkerStatementEvent::dispatch($statement, $context);
        }

        return $context;
    }

    private function Stmt_Expression($statement, VariableContext $context)
    {
        if ($statement->expr instanceof Assign) {
            $context->assignLocalVariable($statement->expr);
        }

        if ($call = ExpressionHelper::getCallLike($statement)) {
            $definition = LoadCallLikeDefinitionEvent::dispatch($call, $context);
            if (isset($definition[0])) {
                $this->recurse(
                    $definition[0]->stmts,
                    $context->contextFromArgs($call, $definition[0])
                );
            }
        }
    }

    private function Stmt_If(If_ $statement, $context)
    {
        $this->recurse($statement->stmts, $context);

        if ($statement->elseifs) {
            foreach($statement->elseifs as $elseif) {
                $this->recurse($elseif->stmts, $context);
            }
        }

        if ($statement->else) {
            $this->recurse($statement->else->stmts, $context);
        }
    }

    private function Stmt_While($statement, $context)
    {
        $this->recurse($statement->stmts, $context);
    }

    private function Stmt_Nop($statement, $context)
    {
    }

    private function Stmt_Return($statement, $context)
    {
    }

    private function Scalar_LNumber($statement, $context)
    {
    }

    private function Stmt_Echo($statement, $context)
    {
    }

    private function Stmt_Class($statement, $context)
    {
    }

    private function Stmt_Function($statement, $context)
    {
    }

    private function Stmt_Throw($statement, $context)
    {
    }

    private function Stmt_TryCatch($statement, $context)
    {
    }

}
