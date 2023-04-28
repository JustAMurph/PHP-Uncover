<?php

namespace App\Plugins\CakePHP4;

use App\Plugins\Plugin;
use App\Signature\ConditionalSink;
use App\Signature\Conditions;
use App\Signature\Signature;
use App\Source\CausesTaint\ConditionalExpressionSource;
use App\Source\CausesTaint\ExpressionConditions\IsArrayAccess;
use App\Source\CausesTaint\ExpressionConditions\RequiresPastCallLike as RequiresPastCallLikeCondition;
use App\Source\CausesTaint\MethodCall;
use App\Utility\Regex;
use App\Vulnerabilities\Definitions\Conditions\MatchesSignature;
use App\Vulnerabilities\Definitions\Conditions\RequiresPastCallLike;
use App\Vulnerabilities\Definitions\CustomSink;
use App\Vulnerabilities\Severity;
use PhpParser\Node\Expr\StaticCall;

class CakePHP4 extends Plugin
{
    public function initialize()
    {
        $this->addConfigParser(new ConfigParser());
        $this->addConfigLocator(new ConfigLocator());

        $this->addRouteParser(new ControllerRouteParser());

        $this->addRouteParser(
            new FileRouteParser($this->getDefinitionHandler())
        );

        $this->addSources([
            MethodCall::withSignature('this', 'request', 'getParam'),
            MethodCall::withSignature('this', 'request', 'param'),
            MethodCall::withSignature('this', 'request', 'getQuery'),
            MethodCall::withSignature('this', 'request', 'getQueryParams'),
            MethodCall::withSignature('this', 'request', 'input'),
            MethodCall::withSignature('this', 'request', 'getHeader'),
            MethodCall::withSignature('this', 'request', 'getCookie'),
            MethodCall::withSignature('this', 'request', 'getData'),
            new ConditionalExpressionSource([
                new IsArrayAccess(),
                new RequiresPastCallLikeCondition(new Signature('this', 'request', 'getQueryParams'))
            ])
        ]);


        $sinks = [
            (new CustomSink('SQL Injection can in severe cases lead to remote code execution on the server. In other less severe
        vulnerabilities full or partial database exfiltration can occur.', 'When using a PHP framework ensure that you use the correct ORM methods. If raw queries are required ensure that data is explicitly sanitised before
        its executed.', Severity::HIGH))->setSignature('DB', 'statement'),
            (new CustomSink('SQL Injection can in severe cases lead to remote code execution on the server. In other less severe
        vulnerabilities full or partial database exfiltration can occur.', 'When using a PHP framework ensure that you use the correct ORM methods. If raw queries are required ensure that data is explicitly sanitised before
        its executed.', Severity::HIGH))->setSignature(Regex::ANY_WORD, 'whereRaw'),
            (new CustomSink('Command injection allows a user to gain remote code execution privileges on the server.', 'Ensure that any calls to execution function are escaped. escapeshellarg() and escapeshellcmd() both help in this regard.', Severity::HIGH))->setSignature('Artisan', 'call')
        ];

        $sinks[] = new ConditionalSink([
            new MatchesSignature(new Signature(Regex::ANY_WORD, 'execute')),
            new RequiresPastCallLike(new Signature('ConnectionManager', 'get'))
        ], 'SQL Injection can in severe cases lead to remote code execution on the server. In other less severe
        vulnerabilities full or partial database exfiltration can occur.', Severity::HIGH, 'Avoid using the ConnectionManager. Use the ORM instead.');

        $this->addSinks($sinks);
    }

    public static function getName(): string
    {
        return 'cakephp4';
    }
}
