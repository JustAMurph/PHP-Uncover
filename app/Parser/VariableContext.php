<?php

namespace App\Parser;

use App\Events\NewCallLikeContextEvent;
use App\Events\NewLocalVariableEvent;
use App\Parser\UserControllableValue;
use App\RouteParser\Route;
use App\Utility\SearchAttribute;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use function collect;

class VariableContext
{
    public $globals;
    public $properties;
    public $local;
    public Route $route;

    public function __construct()
    {
        $this->globals = collect();
        $this->properties = collect();
        $this->local = collect();
    }

    public function assignLocalVariable(Assign $expression)
    {
        $this->addLocalVariable($expression->var, $expression->expr);
    }

    public function addLocalVariable(Variable $var, $value)
    {
        if ($value instanceof Variable) {
            $alreadyDefined = $this->localVarByName($value->name);
            if ($alreadyDefined) {
                $value = $alreadyDefined->key;
            }
        }

        $kv = new KeyValueVariable($var, $value);

        NewLocalVariableEvent::dispatch($kv, $this);
        $this->local->push($kv);
    }

    public function newLocalContext()
    {
        $n = clone($this);
        $n->local = collect();

        return $n;
    }

    public function contextFromArgs($funcCall, $funcDefinition)
    {
        if (empty($funcCall->args)) {
            return $this->newLocalContext();
        }

        $newContext = $this->newLocalContext();

        foreach($funcCall->args as $k => $arg) {
            $nVar = $funcDefinition->params[$k];

            if ($arg->value instanceof Variable) {
                $oldVar = $this->localVarByName($arg->value->name);
                NewCallLikeContextEvent::dispatch(
                    $funcCall,
                    $funcDefinition,
                    $oldVar->key,
                    $nVar->var
                );

                $newContext->local->push(new KeyValueVariable($nVar->var, $oldVar));
            } else if ($arg->value instanceof ArrayDimFetch) {
                $newContext->addLocalVariable($nVar->var, $arg->value);
            } else if ($arg->value instanceof CallLike) {

            }

        }

        return $newContext;
    }

    public function getClassNameFromLocalVar($var)
    {
        $v = $this->localVarByName($var);

        if (!$v) {
            return;
        }

        if ($v->value instanceof New_) {
            return $v->value->class->getFirst();
        }
    }

    public function localVarFromArgs($args)
    {
        foreach ($args as $arg) {

            if (!isset($arg->value->name)) {
                continue;
            }

            $local = $this->localVarByName($arg->value->name);
            if ($local) {
                return $local;
            }

        }

        return false;
    }

    public function taintedLocalVarFromArgs($args)
    {
        $var = $this->localVarFromArgs($args);
        if ($this->isTainted($var)) {
            return $var;
        }
    }

    public function taintedLocalVar($name)
    {
        $var = $this->localVarByName($name);
        if ($this->isTainted($var)) {
            return $var;
        }
    }

    public function isTaintedVariable(Variable $variable)
    {
        return $this->isTainted($this->localVarByName($variable->name));
    }

    public function isTainted($keyValueVariable)
    {
        if (!$keyValueVariable) {
            return false;
        }

         return (bool) (new SearchAttribute('from'))
            ->searchForExistence($keyValueVariable->key, 'tainted');
    }

    public function setFromForExpression(Expr $expr)
    {
        if (!$expr instanceof Variable) {
            return;
        }

        $localVar = $this->localVarByName($expr->name);
        if ($localVar) {
            $expr->setAttribute('from', $localVar->value);
        }
    }

    /**
     *
     * @todo This should be refactored into the 'source' causesTaint classes
     * @param ClassMethod $classMethod
     * @return void
     */
    public function loadVariablesFromClassMethod(ClassMethod $classMethod)
    {
        foreach($classMethod->params as $param) {
            // We're instantiating a new Object from the container most likely.
            if ($param->type) {
                $value = new Instantiation($param->type);
            } else {
                $value = new UserControllableValue();
            }

            $this->addLocalVariable($param->var, $value);
        }
    }

    public function localVarByName($name)
    {
        return $this->local->first(function (KeyValueVariable $value, $key) use ($name) {
            return $value->key->name == $name;
        });
    }

    public static function fromRoute(Route $route)
    {
        $context = new VariableContext();
        $context->route = $route;

        if ($route->getExpr() instanceof ClassMethod) {
            $context->loadVariablesFromClassMethod($route->getExpr());
        }

        return $context;
    }
}
