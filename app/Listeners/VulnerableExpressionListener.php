<?php

namespace App\Listeners;

use App\Events\AfterContextWalkerStatementEvent;
use App\Parser\KeyValueVariable;
use App\Parser\VariableContext;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

class VulnerableExpressionListener extends BaseVulnerableListener
{
    public function handle(AfterContextWalkerStatementEvent $event)
    {
        if (!$event->statement instanceof Expression) {
            return;
        }

        $expr = $event->statement->expr;

        $vulnerability = $this->sinkRepository->findByExpression($expr);
        if (!$vulnerability) {
            return;
        }

        $tainted = $this->getTaintedFromExpression($expr, $event->context);

        if (!$tainted) {
            return;
        }

        $this->createSink($tainted->key, $expr, $vulnerability, $event->context->route);
    }

    private function getTaintedFromExpression(Expr $expr, VariableContext $context)
    {
        if ($expr instanceof Variable) {
            return $context->taintedLocalVar($expr->name->name);
        }

        if ($expr instanceof Expr\Include_) {
            if ($this->sourceRepository->isSource($expr->expr, $context)) {

                if ($expr->expr instanceof Expr\ArrayDimFetch) {
                    $this->setFromForArrayDimFetchArgument($expr->expr, $context);
                }

                return new KeyValueVariable($expr->expr, null);
            }

            if ($expr->expr instanceof Variable) {
                return $context->taintedLocalVar($expr->expr->name);
            }
        }
        return false;
    }
}
