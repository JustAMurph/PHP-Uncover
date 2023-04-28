<?php

namespace App\Vulnerabilities\Definitions;

use App\Vulnerabilities\BaseVulnerability;
use App\Vulnerabilities\Severity;

class CommandInjection extends BaseVulnerability
{
    public array $functions = [
        'exec',
        'shell_exec',
        'passthru',
        'system'
    ];

    function getDescription(): string
    {
        return 'Command injection allows a user to gain remote code execution privileges on the server.';
    }

    function getSeverity(): Severity
    {
        return Severity::HIGH;
    }

    function getRemediation(): string
    {
        return 'Ensure that any calls to execution function are escaped. escapeshellarg() and escapeshellcmd() both help in this regard.';
    }
}
