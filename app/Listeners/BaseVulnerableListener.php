<?php

namespace App\Listeners;

use App\EntryPoint\EntryPoint;
use App\EntryPoint\EntryPointCollection;
use App\Parser\VariableContext;
use App\Source\Repository as SourceRepository;
use App\Utility\ExpressionHelper;
use App\Vulnerabilities\Repository as SinkRepository;
use App\Vulnerabilities\Sink;
use PhpParser\Node\Expr\ArrayDimFetch;

abstract class BaseVulnerableListener
{
    protected SourceRepository $sourceRepository;
    protected SinkRepository $sinkRepository;

    public function __construct(SourceRepository $sourceRepository, SinkRepository $sinkRepository)
    {
        $this->results = new EntryPointCollection();
        $this->sourceRepository = $sourceRepository;
        $this->sinkRepository = $sinkRepository;
    }

    protected function createSink($var, $expr, $vulnerability, $route)
    {
        $sink = new Sink(ExpressionHelper::friendlyName($expr), $expr);
        $this->results->push(new EntryPoint($sink, $var, $vulnerability, $route));
    }

    protected function setFromForArrayDimFetchArgument(ArrayDimFetch $array, VariableContext $context)
    {
        if (!in_array($array->var->name, ['_GET', '_POST', '_COOKIE', '_REQUEST'])) {
            $n = $context->localVarByName($array->var->name);
            $array->setAttribute('from', $n->key);
        }
    }
}
