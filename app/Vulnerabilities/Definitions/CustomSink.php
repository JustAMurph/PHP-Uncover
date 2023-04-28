<?php

namespace App\Vulnerabilities\Definitions;

use App\Parser\VariableContext;
use App\Signature\UsesSignatures;
use App\Utility\CallLikeHelper;
use App\Vulnerabilities\BaseVulnerability;
use App\Vulnerabilities\Severity;
use PhpParser\Node\Expr\CallLike;

class CustomSink extends BaseVulnerability
{
    use UsesSignatures;

    private string $description;
    private string $remediation;
    private Severity $severity;

    public function __construct($description, $remediation, $severity)
    {
        $this->description = $description;
        $this->remediation = $remediation;
        $this->severity = $severity;
    }

    function getDescription(): string
    {
        return $this->description;
    }

    function getSeverity(): Severity
    {
        return $this->severity;
    }

    function getRemediation(): string
    {
        return $this->remediation;
    }

    public function isExecutedBy(CallLike $callLike, VariableContext $context) : bool
    {
        return $this->signature->matches($callLike, $context);
    }
}
