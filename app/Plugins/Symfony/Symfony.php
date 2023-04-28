<?php

namespace App\Plugins\Symfony;

use App\Plugins\Plugin;
use App\Signature\Signature;
use App\Source\CausesTaint\CallLikeConditions\RequiresPastType;
use App\Source\CausesTaint\CallLikeConditions\RequiresSignature;
use App\Source\CausesTaint\ConditionalCallLikeSource;
use App\Utility\Regex;

class Symfony extends Plugin
{
    function initialize()
    {
        $this->addConfigLocator(new ConfigLocator());
        $this->addConfigParser(new ConfigParser());
        $this->addRouteParser(new AnnotationRouteParser());


        $this->addSources([
            new ConditionalCallLikeSource([
                new RequiresSignature(new Signature(Regex::ANY_WORD, 'get|post')),
                new RequiresPastType('Request')
            ]),
            new ConditionalCallLikeSource([
                new RequiresSignature(new Signature(Regex::ANY_WORD, 'request|cookies|query|files|server|header', 'get|all')),
                new RequiresPastType('Request')
            ]),
        ]);
    }

    public static function getName(): string
    {
        return 'symfony';
    }
}
