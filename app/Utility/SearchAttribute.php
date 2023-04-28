<?php

namespace App\Utility;

use PhpParser\Node;

class SearchAttribute
{

    private $attribute;

    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    public function searchForType(Node $node, $type)
    {
        $attribute = $node->getAttribute($this->attribute);

        if (!$attribute) {
            return;
        }

        if ($attribute instanceof $type) {
            return $attribute;
        } else {
            return $this->searchForType($attribute, $type);
        }
    }

    public static function searchFrom(Node $node, $search)
    {

        $success = $search($node);
        if ($success) {
            return true;
        }

        $from = $node->getAttribute('from');
        if ($from) {
            return static::searchFrom($from, $search);
        }


        return false;
    }

    public function searchForExistence(Node $node, $search)
    {
        if ($node->hasAttribute($search)) {
            return $node->getAttribute($search);
        }

        $attribute = $node->getAttribute($this->attribute);

        if (!$attribute) {
            return;
        }

        if ($attribute->getAttribute($search)) {
            return $attribute;
        } else {
            return $this->searchForExistence($attribute, $search);
        }
    }
}
