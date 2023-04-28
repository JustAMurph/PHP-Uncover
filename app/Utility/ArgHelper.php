<?php

namespace App\Utility;

use PhpParser\Node\Arg;

class ArgHelper
{
    public static function toString($args)
    {
        $identifiers = [];

        foreach($args as $arg) {
            /**
             * @var Arg $arg
             */
            // @todo Handle no-name args?
            if (!isset($arg->value->name)) {

            } else {
                $identifiers[] = '$' . $arg->value->name;
            }
        }

        return '(' . implode(',', $identifiers) . ')';
    }

}
