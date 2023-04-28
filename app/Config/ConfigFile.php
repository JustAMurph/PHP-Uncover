<?php

namespace App\Config;

use function collect;

class ConfigFile
{
    public $path;
    public $variables;

    public function __construct($path, $variables = null)
    {
        $this->path = $path;

        if (!$variables) {
            $variables = collect();
        }

        $this->variables = $variables;
    }

    public function relativeTo($path)
    {
        return str_replace($path, '', $this->path);
    }
}
