<?php

namespace App\ApplicationDefinitions\Definitions;

use Illuminate\Support\Collection;

class FunctionDefinitionCollection extends Collection
{
    public function byName($name)
    {
        return $this->first(function($v, $k) use ($name) {
            return $v->name->name == $name;
        });
    }
}
