<?php

namespace App\Plugins\Slim;

use App\Config\IParseConfig;
use App\Config\VariableCollection;
use App\Utility\ArrayParser;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\New_;

class ConfigParser implements IParseConfig
{

    public function parseFile(\SplFileInfo $config): VariableCollection
    {
        $ast = AST::fromSplFile($config);

        $class = (new EnhancedNodeFinder())->findFirst($ast, function($node) {
            if (!$node instanceof New_) {
                return;
            }

            return $node->class->getFirst() == 'Settings';
        });

        return (new ArrayParser())->undotted($class->args[0]->value)
            ->pipeInto(VariableCollection::class);
    }
}
