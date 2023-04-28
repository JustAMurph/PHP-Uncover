<?php

namespace App\Source;

use App\Events\LoadSources;
use App\Parser\KeyValueVariable;
use App\Parser\VariableContext;
use App\Source\CausesTaint\Collection;
use App\Source\CausesTaint\SuperGlobal;
use App\Utility\CallLikeHelper;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\Variable;

class Repository
{
    /**
     * @var Collection
     */
    public $sources;

    public function __construct()
    {
        $sources = new Collection([new SuperGlobal()]);

        $r = LoadSources::dispatch();

        foreach($r as $newSource) {
            $sources = $sources->merge($newSource);
        }

        $this->sources = $sources;
    }


    /**
     * Whether the CallLike causes a variable to become tainted.
     *
     * @param CallLike $callLike
     * @return void
     */
    private function causesTaint(CallLike $callLike, VariableContext $context = null) : bool
    {
        return $this->sources->isSourceCallLike($callLike, $context);
    }

    public function isSource($expr, VariableContext $context = null)
    {
        if ($expr instanceof CallLike)
        {
            return $this->causesTaint($expr, $context);
        }

        return $this->sources->isSourceExpression($expr, $context);
    }

    public function isSourceOrTainted($expr, VariableContext $context) : bool
    {
        if ($expr instanceof Variable) {
            if ($context->isTaintedVariable($expr)) {
                return true;
            }
        }

        return $this->isSource($expr, $context);
    }

    public function getSourceVarFromArgs(array $args, VariableContext $context)
    {
        foreach ($args as $arg) {
            /**
             * @var Arg $arg
             */
            if ($arg->value instanceof Concat) {
                $source = $this->getSourceFromConcat($arg->value, $context);
                if ($source) {
                    $context->setFromForExpression($source);
                    return new KeyValueVariable($source, null);
                }
            }

            if ($this->isSource($arg->value, $context)) {
                return new KeyValueVariable($arg->value, null);
            }
        }
    }

    /**
     * This could be recursive...
     *
     * @param Concat $concat
     * @param VariableContext $variableContext
     * @return \PhpParser\Node\Expr
     */
    public function getSourceFromConcat(Concat $concat, VariableContext $variableContext)
    {
        if ($this->isSourceOrTainted($concat->left, $variableContext)) {
            return $concat->left;
        } else if ($this->isSourceOrTainted($concat->right, $variableContext)) {
            return $concat->right;
        }
    }

    public function getMetaData($key, $value, VariableContext $context)
    {
        if ($value instanceof CallLike) {
            $source = $this->sources->getSourceFromCallLike($value, $context);
            return $source->createMetaFromCallLike($key, $value);
        } else {
            $source = $this->sources->getSourceFromExpression($value, $context);
            return $source->createMetaDataFromExpression($key, $value);
        }
    }
}
