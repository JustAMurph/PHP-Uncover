<?php

namespace App\Plugins\CodeIgniter3;

use App\Plugins\Plugin;
use App\Source\CausesTaint\MethodCall;
use App\Vulnerabilities\Definitions\CustomSink;
use App\Vulnerabilities\Severity;

class CodeIgniter3 extends Plugin
{
    function initialize()
    {
        $this->applicationDefinitionClass = CodeIgniter3Definitions::class;

        $this->addRouteParser(new ControllerRouteParser());
        $this->addRouteParser(new FileRouteParser($this->getDefinitionHandler()));

        $this->addConfigLocator(new ConfigLocator());
        $this->addConfigParser(new ConfigParser());

        $this->addSources([
            MethodCall::withSignature('this', 'input', 'get'),
            MethodCall::withSignature('this', 'input', 'post'),
            MethodCall::withSignature('this', 'input', 'server'),
            MethodCall::withSignature('this', 'input', 'cookie'),
        ]);

        $this->addSinks([
            (new CustomSink('SQL Injection can in severe cases lead to remote code execution on the server. In other less severe
        vulnerabilities full or partial database exfiltration can occur.', 'Sanitize all input.', Severity::HIGH))->setSignature('this', 'db', 'query'),
            (new CustomSink('File inclusion attacks allow a malicious attacker to include custom PHP files into the web page for execution.
        This can allow the attacker full remote code execution privileges as the web server user.', 'Always ensure that data is sanitised prior to it\'s use. When dynamically including files ensure that the final file path does not contain
        special characters. Assert that the final resolve file path does not point to different directories.', Severity::HIGH))->setSignature('this', 'load', 'view')
        ]);
    }

    public static function getName(): string
    {
        return 'codeigniter3';
    }
}
