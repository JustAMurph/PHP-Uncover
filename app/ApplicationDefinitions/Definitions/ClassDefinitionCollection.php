<?php

namespace App\ApplicationDefinitions\Definitions;

use App\Utility\EnhancedNodeFinder;
use Illuminate\Support\Collection;
use PhpParser\Node\Stmt\ClassMethod;

class ClassDefinitionCollection extends Collection
{
    public function byName($className)
    {
        return $this->first(function($v, $k) use($className) {
            if (!$v->name) {
                return false;
            }

            return $v->name->name == $className;
        });
    }

    public function findClassMethod($className, $method)
    {
        $class = $this->byName($className);

        if (!$class) {
            return;
        }

        $finder = resolve(EnhancedNodeFinder::class);
        return $finder->findFirst($class->stmts, function($node) use ($method) {
            if (!$node instanceof ClassMethod) {
                return;
            }

            return $node->name->name == $method;
        });
    }
}
