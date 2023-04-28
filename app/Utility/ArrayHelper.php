<?php

namespace App\Utility;

use PhpParser\Node\Expr\Array_;

class ArrayHelper
{
    public static function findByKey(Array_ $array_, $key)
    {
        foreach($array_->items as $item) {
            if ($item->key->value == $key) {
                return $item->value->value;
            }
        }
    }
}
