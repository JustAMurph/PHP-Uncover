<?php

namespace App\Utility;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Scalar;
use PhpParser\PrettyPrinter\Standard;

class ArrayParser
{
    private Standard $prettyPrinter;

    public function __construct()
    {
        $this->prettyPrinter = new Standard();
    }

    public function undotted(Array_ $array_) : Collection
    {
        return collect(Arr::undot($this->parse($array_)));
    }

    public function dotted(Array_ $array_) : Collection
    {
        return $this->parse($array_);
    }

    private function parse(Array_ $array, $key = '') {
        $result = collect();
        $n = 0;
        foreach ($array->items as $arrayItem) {
            $k = $this->getKey($key, $arrayItem, $n);

            if (isset($arrayItem->value) && !$arrayItem->value instanceof Array_) {
                $result->put($k, $this->getStringValue($arrayItem->value));
            }

            if (isset($arrayItem->value) &&  $arrayItem->value instanceof Array_) {
                if (empty($key)) {
                    $nextKey = '';
                } else {
                    $nextKey = '.';
                }

                if (isset($arrayItem->key)) {
                    $nextKey .= $arrayItem->key->value;
                }

                $result = $result->merge($this->parse($arrayItem->value, $nextKey));
            }

            $n++;
        }
        return $result;
    }

    private function getKey($key, $value, $n)
    {
        $result = [];

        if (!empty($key)) {
            $result[] = $key;
        }

        if ($value instanceof ArrayItem)
        {
            if ($value->key instanceof FuncCall) {
                $result[] = $value->key->name->getFirst();
            }else if (!empty($value->key)) {
                $result[] = $value->key->value;
            } else {
                $result [] = $n;
            }
        }

        return implode('.', $result);
    }

    private function getStringValue($expr)
    {
        if ($expr instanceof Scalar) {
            return $expr->value;
        }

        if ($expr instanceof ConstFetch) {
            return $expr->name->getFirst();
        }

        return $this->prettyPrinter->prettyPrintExpr($expr);
    }
}
