<?php

namespace App\Vulnerabilities\Definitions;

use App\Vulnerabilities\BaseVulnerability;
use App\Vulnerabilities\Severity;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Include_;

class FileInclusion extends BaseVulnerability
{
    public array $functions = [
        'require',
        'require_once',
        'include',
        'include_once'
    ];

    protected array $expressions = [
        Include_::class
    ];

    function getDescription(): string
    {
        return 'File inclusion attacks allow a malicious attacker to include custom PHP files into the web page for execution.
        This can allow the attacker full remote code execution privileges as the web server user.';
    }

    function getSeverity(): Severity
    {
        return Severity::MEDIUM;
    }

    function getRemediation(): string
    {
        return 'Always ensure that data is sanitised prior to it\'s use. When dynamically including files ensure that the final file path does not contain
        special characters. Assert that the final resolve file path does not point to different directories.';
    }

    public function isVulnerableExpression(Expr $expr) : bool
    {
        foreach ($this->expressions as $possible)
        {
            if (is_a($expr, $possible)) {
                return true;
            }
        }

        return false;
    }
}
