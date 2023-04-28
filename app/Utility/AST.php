<?php

namespace App\Utility;

use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\ParentConnectingVisitor;
use PhpParser\Parser;

class AST
{
    public static function fromSplFile(\SplFileInfo $fileInfo) {
        return static::fromFile($fileInfo->getPathname());
    }

    public static function fromFile($file)
    {
        $parser = resolve(Parser::class);
        $ast = $parser->parse(file_get_contents($file));
        $traverser = new NodeTraverser;
        $traverser->addVisitor(new ParentConnectingVisitor);
        return $traverser->traverse($ast);
    }
}
