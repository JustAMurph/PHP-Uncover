<?php

namespace App\Plugins\Slim;

use App\Plugins\Plugin;
use App\Signature\Signature;
use App\Source\CausesTaint\ArrayAccessAfterCallLike;
use App\Source\CausesTaint\ConditionalCallLikeSource;
use App\Source\CausesTaint\CallLikeConditions\RequiresPastType;
use App\Source\CausesTaint\CallLikeConditions\RequiresSignature;
use App\Source\CausesTaint\ConditionalExpressionSource;
use App\Source\CausesTaint\ExpressionConditions\IsArrayAccess;
use App\Source\CausesTaint\ExpressionConditions\RequiresPastCallLike;
use App\Source\CausesTaint\MethodCallOfType;
use App\Source\CausesTaint\MethodCall;
use App\Utility\Regex;

class Slim extends Plugin
{
    function initialize()
    {
        $this->addConfigParser(new ConfigParser());
        $this->addRouteParser(new RouteParser($this->getDefinitionHandler()));
        $this->addConfigLocator(new ConfigLocator());

        $this->addSources([
            MethodCall::withSignature('this', 'resolveArg'),
            new ConditionalCallLikeSource([
                new RequiresSignature(new Signature(Regex::ANY_WORD, 'get')),
            ]),
            new ConditionalCallLikeSource([
                new RequiresSignature(new Signature(Regex::ANY_WORD, 'get')),
                new RequiresPastType('Request')
            ]),
            new ConditionalExpressionSource([
                new IsArrayAccess(),
                new RequiresPastCallLike(new Signature('this', 'request', 'getQueryParams|getParsedBody'))
            ])
        ]);
    }

    public static function getName(): string
    {
        return 'slim';
    }
}
