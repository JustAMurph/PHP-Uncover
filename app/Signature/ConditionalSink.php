<?php

namespace App\Signature;

use App\Parser\VariableContext;
use App\Utility\CallLikeHelper;
use App\Utility\Regex;
use App\Utility\SearchAttribute;
use App\Vulnerabilities\BaseVulnerability;
use App\Vulnerabilities\Severity;
use Closure;
use PhpParser\Node\Expr\CallLike;

class ConditionalSink extends BaseVulnerability
{
    private $conditions;
    private $description;
    private Severity $severity;
    private $remediation;

    /**
     * @param $class
     * @param $method array The method that executes the class.
     */
    public function __construct($conditions, $description, Severity $severity, $remediation)
    {
        $this->conditions = $conditions;
        $this->description = $description;
        $this->severity = $severity;
        $this->remediation = $remediation;
    }

    public function isExecutedBy(CallLike $callLike, VariableContext $context): bool
    {
        foreach ($this->conditions as $condition) {
            /**
             * @var IMatchCallLike $condition
             */
            if (!$condition->matches($callLike, $context)) {
                return false;
            }
        }

        return true;
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
}
