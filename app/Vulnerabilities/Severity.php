<?php

namespace App\Vulnerabilities;

enum Severity : string
{
    case CRITICAL = 'Critical';
    case HIGH = 'High';
    case MEDIUM = 'Medium';
    case LOW = 'Low';
    case INFORMATIONAL = 'Informational';
}
