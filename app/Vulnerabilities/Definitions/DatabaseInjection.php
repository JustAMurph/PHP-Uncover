<?php

namespace App\Vulnerabilities\Definitions;

use App\Vulnerabilities\BaseVulnerability;
use App\Vulnerabilities\Severity;

class DatabaseInjection extends BaseVulnerability
{

    function getDescription(): string
    {
        return 'SQL Injection can in severe cases lead to remote code execution on the server. In other less severe
        vulnerabilities full or partial database exfiltration can occur.';
    }

    function getSeverity(): Severity
    {
        return Severity::MEDIUM;
    }

    function getRemediation(): string
    {
        return 'When using a PHP framework ensure that you use the correct ORM methods. If raw queries are required ensure that data is explicitly sanitised before
        its executed.';
    }
}
