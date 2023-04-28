<?php

namespace App\Credentials;

use Illuminate\Support\Str;

class Keywords
{
    public static function get()
    {
        return ['username', 'pass'];
    }

    public static function isCredential($str)
    {
        if (!is_string($str)) {
            return false;
        }

        return Str::contains($str, static::get());
    }
}
