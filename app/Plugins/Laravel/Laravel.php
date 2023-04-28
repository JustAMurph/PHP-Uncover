<?php

namespace App\Plugins\Laravel;

use App\Plugins\Plugin;
use App\Signature\Signature;
use App\Source\CausesTaint\CallLikeConditions\RequiresPastType;
use App\Source\CausesTaint\CallLikeConditions\RequiresSignature;
use App\Source\CausesTaint\ConditionalCallLikeSource;
use App\Source\CausesTaint\MethodCall;
use App\Utility\Regex;
use App\Vulnerabilities\Definitions\CustomSink;
use App\Vulnerabilities\Severity;

class Laravel extends Plugin
{
    function initialize()
    {
        $this->addConfigParser(new ConfigParser());
        $this->addConfigLocator(new ConfigLocator());
        $this->addRouteParser(new RouteParser($this->getDefinitionHandler()));

        $this->addSources([
            new ConditionalCallLikeSource([
                new RequiresSignature(new Signature(Regex::ANY_WORD, 'get|post|query|cookie|input')),
                new RequiresPastType('Request')
            ]),
        ]);

        $this->addSinks([
            (new CustomSink('SQL Injection can in severe cases lead to remote code execution on the server. In other less severe
        vulnerabilities full or partial database exfiltration can occur.', 'When using a PHP framework ensure that you use the correct ORM methods. If raw queries are required ensure that data is explicitly sanitised before
        its executed.', Severity::HIGH))->setSignature('DB', 'statement'),
            (new CustomSink('SQL Injection can in severe cases lead to remote code execution on the server. In other less severe
        vulnerabilities full or partial database exfiltration can occur.', 'When using a PHP framework ensure that you use the correct ORM methods. If raw queries are required ensure that data is explicitly sanitised before
        its executed.', Severity::HIGH))->setSignature(Regex::ANY_WORD, 'whereRaw'),
            (new CustomSink('Command injection allows a user to gain remote code execution privileges on the server.', 'Ensure that any calls to execution function are escaped. escapeshellarg() and escapeshellcmd() both help in this regard.', Severity::HIGH))->setSignature('Artisan', 'call')
        ]);
    }

    public static function getName(): string
    {
        return 'laravel';
    }
}
