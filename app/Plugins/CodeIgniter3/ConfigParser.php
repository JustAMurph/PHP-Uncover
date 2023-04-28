<?php

namespace App\Plugins\CodeIgniter3;

use App\Config\IParseConfig;
use App\Config\VariableCollection;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar;

class ConfigParser implements IParseConfig
{
    public function parseFile(\SplFileInfo $config): VariableCollection
    {
        $ast = AST::fromSplFile($config);

        $assignments = (new EnhancedNodeFinder())->findInstanceOf($ast, Assign::class);
        /**
         * @var Assign[] $assignments
         */

        $result = new VariableCollection();

        foreach($assignments as $assignment) {
            $this->handleAssignment($assignment, $result);
        }

        return $result;
    }

    private function handleAssignment(Assign $assign, VariableCollection $collection)
    {
        // Assigning to Array.
        if ($assign->var instanceof ArrayDimFetch) {

            $v = $collection->get($assign->var->var->name);

            if (!$v) {
                $v = [];
            }

            $v[$assign->var->dim->value] = $this->getAssumedValue($assign->expr);
            $collection->put($assign->var->var->name, $v);
        }

        // Standard Variable
        if ($assign->var instanceof Variable) {
            $collection->put($assign->var->name, $this->getAssumedValue($assign->expr));
        }
    }

    private function getAssumedValue(Expr $expression) {
        if (is_subclass_of($expression, Scalar::class)) {
            return $expression->value;
        }

        if ($expression instanceof Expr\ConstFetch) {
            return $expression->name->getFirst();
        }

        if ($expression instanceof Expr\Array_) {
            $rebuild = [];

            foreach ($expression->items as $item) {
                if ($item->value instanceof Scalar) {
                    $rebuild[$item->key->value] = $item->value->value;
                }
            }
            return $rebuild;
        }
    }
}
