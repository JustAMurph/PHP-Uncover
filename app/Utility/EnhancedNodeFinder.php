<?php

namespace App\Utility;

use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeFinder;

class EnhancedNodeFinder extends NodeFinder
{
    public function findByNameAndType($stmts, $method, $type=ClassMethod::class) : mixed
    {
        return $this->findFirst($stmts, function($node) use ($method, $type) {
            if (!$node instanceof $type) {
                return;
            }

            return $node->name->name === $method;
        });
    }

    public function findPublicClassMethods($stmts)
    {
        return $this->find($stmts, function($node) {
            if (!$node instanceof ClassMethod) {
                return;
            }

            return $node->isPublic();
        });
    }

    public function findTypeWithExpressionType($stmts, $type, $expression)
    {
        return $this->findFirst($stmts, function($node) use ($type, $expression) {
            if (!$node instanceof $type) {
                return;
            }

            if (!$node->expr instanceof $expression) {
                return;
            }

            return true;
        });
    }
}
