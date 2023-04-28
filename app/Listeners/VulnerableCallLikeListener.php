<?php

namespace App\Listeners;

use App\Events\AfterContextWalkerStatementEvent;
use App\Parser\VariableContext;
use App\Utility\ExpressionHelper;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\Expression;

class VulnerableCallLikeListener extends BaseVulnerableListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AfterContextWalkerStatementEvent $event)
    {
        if (!$event->statement instanceof Expression) {
            return;
        }

        list($call, $vulnerability) = $this->searchVulnerabilityFromCallLike($event->statement, $event->context);

        if (!$call || !$vulnerability) {
            return;
        }

        $tainted = $this->getTaintedFromCall($call, $event->context);
        if (!$tainted) {
            return;
        }

        if ($tainted->key instanceof Expr\ArrayDimFetch) {
            // Lets set the 'from' attribute.
            $this->setFromForArrayDimFetchArgument($tainted->key, $event->context);
        }

        $this->createSink($tainted->key, $call, $vulnerability, $event->context->route);
    }

    private function getTaintedFromCall(Expr\CallLike $call, VariableContext $context)
    {
        $tainted = $context->taintedLocalVarFromArgs($call->getArgs());
        if ($tainted) {
            return $tainted;
        }

        return $this->sourceRepository->getSourceVarFromArgs($call->getArgs(), $context);
    }

    private function searchVulnerabilityFromCallLike($statement, VariableContext $context)
    {
        $call = ExpressionHelper::getCallLike($statement);
        if (!$call) {
            return;
        }
        return [$call, $this->sinkRepository->findByCallLike($call, $context)];
    }
}
