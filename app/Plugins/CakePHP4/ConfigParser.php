<?php

namespace App\Plugins\CakePHP4;

use App\Config\IParseConfig;
use App\Config\VariableCollection;
use App\Utility\ArrayParser;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Stmt\Return_;
use SplFileInfo;

class ConfigParser implements IParseConfig
{
    public function parseFile(SplFileInfo $config): VariableCollection
    {
        $ast = AST::fromSplFile($config);

        $return = (new EnhancedNodeFinder())->findFirst($ast, function($node) {
            return $node instanceof Return_ && $node->expr instanceof Array_;
        });

        if (!$return) {
            return new VariableCollection();
        }

        return (new ArrayParser())->undotted($return->expr)
            ->pipeInto(VariableCollection::class);
    }
}
