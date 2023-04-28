<?php

namespace App\Config;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ConfigFileCollection extends Collection
{

    public function toCsvArray()
    {
        $result = [
        ];
        foreach ($this as $config) {
            foreach(Arr::dot($config->variables->all()) as $variable => $value) {
                $result[] = [
                    'path' => $config->path,
                    'variable' => $variable,
                    'value' => $value
                ];
            }
        }

        return $result;
    }
}
