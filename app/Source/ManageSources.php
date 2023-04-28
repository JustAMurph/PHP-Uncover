<?php

namespace App\Source;

use App\Events\LoadSources;
use App\Source\CausesTaint\MethodCall;
use Illuminate\Support\Facades\Event;

trait ManageSources
{
    protected function addSources($sources)
    {
        Event::listen(function(LoadSources $event) use ($sources) {
            return $sources;
        });
    }

    protected function addSourcesFromArray(array $arr)
    {
        $result = [];

        foreach ($arr as $source) {
            $result[] = MethodCall::withSignature(...$source);
        }

        $this->addSources($result);
    }
}
