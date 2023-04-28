<?php

namespace App\Listeners;

use App\Events\NewLocalVariableEvent;
use App\Parser\UserControllableValue;
use App\Parser\VariableContext;
use App\Source\Repository;
use App\Source\SourceChecker;
use App\Utility\ExpressionHelper;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar;

class AssignmentTaintListener
{
    private Repository $sourceRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sourceRepository = new Repository();
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewLocalVariableEvent $event)
    {
        $key = $event->keyValueVariable->key;
        /**
         * @var Variable $key
         */
        $value = $event->keyValueVariable->value;

        $checker = resolve(SourceChecker::class);
        /**
         * @var SourceChecker $checker
         */
        if ($value instanceof Concat) {
            $value = $this->sourceRepository->getSourceFromConcat($value, $event->context);
        }

        if ($value instanceof UserControllableValue) {
            ExpressionHelper::taint($key);
        }

        if ($value instanceof CallLike) {
            if ($this->sourceRepository->isSource($value, $event->context)) {
                $checker->source($key, $value, $event->context);
                ExpressionHelper::taint($key);
            }

            // If the argument value is tainted set the correct attribute.
            foreach($value->getArgs() as $arg) {
                $checker->checkIfSource($key, $arg->value, $event->context, function() use($key) {
                    ExpressionHelper::taint($key);
                });

            }
        }

        if ($value instanceof ArrayDimFetch) {
            $checker->checkIfSource($key, $value->var, $event->context, function() use ($key) {
                ExpressionHelper::taint($key);
            });
        }
    }
}
