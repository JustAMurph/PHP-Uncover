<?php

namespace App\Config;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class VariableCollection extends Collection
{

    public function filterWhenDotted($filter)
    {
        $old = collect(Arr::dot($this));
        return new static(Arr::undot($old->filter($filter)));
    }

    public function removeSpecialTags()
    {
        $undot = Arr::dot($this);
        $new = [];

        foreach($undot as $key => $value) {
            $new[str_replace('@', '', $key)] = $value;
        }

        return Arr::undot($new);
    }

}
