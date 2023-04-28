<?php

namespace App\Vulnerabilities;

use PhpParser\Node\Expr;
use PhpParser\PrettyPrinter\Standard;

/**
 * Represents a particular point of code that executes a vulnerability.
 *
 * This could either be a function or an expression.
 */
class Sink
{

    public string $name;
    public string $code;

    public function __construct($name, $code)
    {

        $this->name = $name;

        if ($code instanceof Expr) {
            $printer = resolve(Standard::class);
            $code = $printer->prettyPrintExpr($code);
        }

        $this->code = $code;
    }
}
