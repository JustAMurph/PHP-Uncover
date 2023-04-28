<?php

namespace App\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SerializationCast implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        try {
            return unserialize($value);
        } catch(\Exception $a) {
            return false;
        }
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return serialize($value);
    }
}
