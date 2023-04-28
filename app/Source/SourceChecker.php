<?php

namespace App\Source;

use App\Parser\VariableContext;
use Closure;
use PhpParser\Node\Expr\Variable;

class SourceChecker
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function checkIfSource(Variable $key, $value, VariableContext $context = null, $callback = null)
    {
        if (!$value instanceof Variable) {
            return;
        }

        if ($this->repository->isSource($value, $context)) {
            $this->source($key, $value, $context);

            if ($callback) {
                $callback();
            }
        }
    }

    public function source($key, $value, VariableContext $context)
    {
        $value->setAttribute('source', true);

        $value->setAttribute(
            'sourceMetadata',
            $this->repository->getMetaData($key, $value, $context)
        );
        $key->setAttribute('from', $value);
    }
}
