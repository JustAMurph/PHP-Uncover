<?php

namespace App\Plugins\Laravel;

use App\Config\IParseConfig;
use App\Config\VariableCollection;
use App\Utility\ArrayParser;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use PhpParser\Node\Stmt\Return_;

class ConfigParser implements IParseConfig
{
    public function parseFile(\SplFileInfo $config): VariableCollection
    {
        $ast = AST::fromSplFile($config);
        $class = (new EnhancedNodeFinder())->findFirstInstanceOf($ast, Return_::class);
        return (new ArrayParser())->undotted($class->expr)
            ->pipeInto(VariableCollection::class);
    }
}
