<?php

namespace App\Plugins;

use App\Plugins\CakePHP4\CakePHP4;
use App\Plugins\CodeIgniter3\CodeIgniter3;
use App\Plugins\Laravel\Laravel;
use App\Plugins\Slim\Slim;
use App\Plugins\Symfony\Symfony;

enum PluginMapping: string
{
    case CodeIgniter3 = CodeIgniter3::class;
    case Laravel = Laravel::class;
    case CakePHP4 = CakePHP4::class;
    case Slim = Slim::class;
    case Symfony = Symfony::class;

    public function name() : string
    {
        return call_user_func([$this->value, 'getName']);
    }

    public static function fromKey($key)
    {
        foreach(static::cases() as $case) {
            if ($key == $case->name()) {
                return $case->value;
            }
        }
    }
}
