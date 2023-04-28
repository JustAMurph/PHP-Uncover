<?php

namespace App\Vulnerabilities;

use App\Events\LoadSinks;
use App\Source\CausesTaint\MethodCall;
use App\Vulnerabilities\Definitions\CustomSink;
use Illuminate\Support\Facades\Event;

trait ManageSinks
{
    protected function addSinks($sinks)
    {
        Event::listen(function(LoadSinks $event) use ($sinks) {
            return $sinks;
        });
    }

    protected function addSinksFromArray(array $arr)
    {
        $result = [];

        foreach ($arr as $source) {

            $result[] = (new CustomSink($source['description'], $source['remediation'], Severity::HIGH))
                ->setSignature(...$source['signature']);
        }

        $this->addSinks($result);
    }
}
