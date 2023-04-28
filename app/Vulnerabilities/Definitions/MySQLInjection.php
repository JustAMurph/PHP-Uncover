<?php

namespace App\Vulnerabilities\Definitions;

class MySQLInjection extends DatabaseInjection
{
    public array $functions = [
        'mysql_query'
    ];
}
