<?php

namespace App\Utility;

class Regex
{
    public const ANY_WORD = "(\w*)";

    /**
     * Compares two arrays. The first array can contain Regex patterns.
     *
     * @param $first
     * @param $second
     * @return bool
     */
    public static function compareArrays($first, $second) : bool
    {
        $i = 0;
        foreach($first as $a) {

            if (!array_key_exists($i, $second)) {
                return false;
            }

            $compare = $second[$i];

            $matches = [];
            if (!preg_match("/" . $a . "/", $compare, $matches)) {
                return false;
            }
            $i++;
        }

        return true;
    }

}
