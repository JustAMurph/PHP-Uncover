<?php

namespace App\Vulnerabilities;

use App\Events\LoadSinks;
use App\Parser\VariableContext;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\CallLike;

class Repository
{
    public VulnerabilityCollection $vulnerabilities;

    public function __construct()
    {
        $this->vulnerabilities = new VulnerabilityCollection();

        $loads = LoadSinks::dispatch();

        foreach ($loads as $load) {
            $this->vulnerabilities = $this->vulnerabilities->merge($load);
        }
    }

    public function findByCallLike(CallLike $callLike, VariableContext $context) : ? BaseVulnerability
    {
        return $this->vulnerabilities->findExecutedBy($callLike, $context);
    }

    public function findByExpression(Expr $expr) : ? BaseVulnerability
    {
        return $this->vulnerabilities->findByVulnerableExpression($expr);
    }
}
