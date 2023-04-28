<?php

namespace App\ApplicationDefinitions\Definitions\Loaders;

use App\ApplicationDefinitions\Definitions\ClassDefinitionCollection;
use App\ApplicationDefinitions\Definitions\FunctionDefinitionCollection;

interface ILoadDefinitions
{
    public function getClassDefinitions(): ClassDefinitionCollection;
    public function getFunctionDefinitions(): FunctionDefinitionCollection;
}
