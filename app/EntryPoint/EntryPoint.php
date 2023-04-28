<?php

namespace App\EntryPoint;

use App\Utility\ArgHelper;
use App\Vulnerabilities\IVulnerability;
use App\RouteParser\Route;
use App\Vulnerabilities\Sink;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\PrettyPrinter\Standard;

class EntryPoint
{

    private Sink $sink;

    public readonly Expr $variable;

    public readonly Route $route;

    public readonly IVulnerability $vulnerability;

    /**
     * @var Standard
     */
    private mixed $printer;

    private string $separator = ' -> ';

    public function __construct(Sink $sink, Expr $variable, IVulnerability $vulnerability, $route = null)
    {
        $this->sink = $sink;
        $this->variable = $variable;
        $this->vulnerability = $vulnerability;
        $this->route = $route;
        $this->printer = resolve(Standard::class);
    }

    /**
     * @return CallLike
     */
    public function getSink(): Sink
    {
        return $this->sink;
    }

    public function toExecutionPath() : string
    {
        return $this->recurse($this);
    }

    private function recurse($item, $str = '')
    {
        if ($item instanceof EntryPoint) {

            $str .= $this->sink->code . $this->separator . $this->printer->prettyPrintExpr($item->variable);

            $from = $item->variable->getAttribute('from');
            if ($from) {
                $str .= $this->separator;
                $str .= $this->recurse($from);
            }

            if ($sourceMeta = $item->variable->getAttribute('sourceMetadata')) {
                $str .= $this->separator . $sourceMeta->description;
            }
            return $str;
        }

        if ($item instanceof Expr && $item->hasAttribute('source')) {
            $str .= $this->printer->prettyPrintExpr($item);
            return $str; // $str .= $item->getAttribute('sourceMetadata')->description;
        }

        $str .= $this->printer->prettyPrintExpr($item);

        $from = $item->getAttribute('from');
        if ($from) {
            $str .= $this->separator;
            return $this->recurse($from, $str);
        }

        return $str;
    }

    public function getVulnerableExecutionName()
    {
        return $this->sink->name;
    }
}
