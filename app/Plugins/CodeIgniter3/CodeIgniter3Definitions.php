<?php

namespace App\Plugins\CodeIgniter3;

use App\ApplicationDefinitions\ApplicationDefinitions;
use App\Parser\VariableContext;
use App\Plugins\Contracts\IHandleDefinitions;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;

class CodeIgniter3Definitions extends ApplicationDefinitions
{
    /**
     * Retrieve the correct method definition for the given $methodCall.
     *
     * Pass in the $context so that variable classes can be found.
     *
     * @param MethodCall $methodCall
     * @param VariableContext $context
     * @return mixed|null
     */
    public function getMethodDefinition(MethodCall $methodCall, VariableContext $context)
    {
        if ($methodCall->var instanceof PropertyFetch) {
            if ($methodCall->var->var->name == 'this' && Str::contains($methodCall->var->name->name, 'model')) {
                $class = $this->classes->byName($methodCall->var->name->name);
                return $this->enhancedNodeFinder->findByNameAndType($class->stmts, $methodCall->name->name);
            }
        }

        return parent::getMethodDefinition($methodCall, $context);
    }
}
