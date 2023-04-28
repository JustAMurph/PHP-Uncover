<?php

namespace App\ApplicationDefinitions;

use App\ApplicationDefinitions\Definitions\ClassDefinitionCollection;
use App\ApplicationDefinitions\Definitions\FunctionDefinitionCollection;
use App\ApplicationDefinitions\Definitions\Loaders\ILoadDefinitions;
use App\Parser\VariableContext;
use App\Utility\SearchAttribute;
use App\Utility\EnhancedNodeFinder;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;

class ApplicationDefinitions
{

    public FunctionDefinitionCollection $functions;
    public ClassDefinitionCollection $classes;
    protected EnhancedNodeFinder $enhancedNodeFinder;

    public function __construct(ILoadDefinitions $loadDefinitions)
    {
        $this->enhancedNodeFinder = new EnhancedNodeFinder();
        $this->classes = $loadDefinitions->getClassDefinitions();
        $this->functions = $loadDefinitions->getFunctionDefinitions();
    }

    public function findClassByName($className)
    {
        return $this->classes->byName($className);
    }

    public function findClassByNameAndMethod($className, $method)
    {
        return $this->classes->findClassMethod($className, $method);
    }

    public function getCallLikeDefinition(CallLike $callLike, VariableContext $context)
    {
        if ($callLike instanceof FuncCall) {
            return $this->getFunctionDefinition($callLike, $context);
        }

        if ($callLike instanceof MethodCall) {
            return $this->getMethodDefinition($callLike, $context);
        }

        if ($callLike instanceof StaticCall) {
            return $this->getStaticCallDefinition($callLike, $context);
        }
    }

    protected function getStaticCallDefinition(StaticCall $staticCall, $context)
    {
        $class = $this->classes->byName($staticCall->class->getFirst());
        if (!$class) {
            return;
        }

        return $this->enhancedNodeFinder->findByNameAndType($class->stmts, $staticCall->name->name);
    }

    protected function getMethodDefinition(MethodCall $method, VariableContext $context)
    {
        $callingVarName = $method->var->name;

        if ($callingVarName === 'this') {
            $class = (new SearchAttribute('parent'))->searchForType($method, Class_::class);
        } else {
            $class = $this->classes->byName(
                $context->getClassNameFromLocalVar($callingVarName)
            );
        }

        if (!$class) {
            return null;
        }

        return $this->enhancedNodeFinder->findByNameAndType($class->stmts, $method->name->name);
    }

    private function getFunctionDefinition($func)
    {
        return $this->functions->byName($func->name->getFirst());
    }
}
