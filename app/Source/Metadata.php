<?php

namespace App\Source;

/**
 * Represents an instance of a source.
 */
class Metadata
{
    public string $variableName;
    public string $description;

    public function __construct($variableName, $description)
    {
        $this->variableName = $variableName;
        $this->description = $description;
    }
}
