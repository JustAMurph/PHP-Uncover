<?php

namespace App\ApplicationDefinitions\Definitions\Loaders;

use App\ApplicationDefinitions\Definitions\ClassDefinitionCollection;
use App\ApplicationDefinitions\Definitions\FunctionDefinitionCollection;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Function_;
use Symfony\Component\Finder\Finder;

class StandardDefinitionLoader implements ILoadDefinitions
{
    private EnhancedNodeFinder $nodeFinder;
    private ClassDefinitionCollection $classDefinitionCollection;
    private FunctionDefinitionCollection $functionDefinitionCollection;

    public function __construct(\SplFileInfo $directory)
    {
        $this->nodeFinder = new EnhancedNodeFinder();
        $this->classDefinitionCollection = new ClassDefinitionCollection();
        $this->functionDefinitionCollection = new FunctionDefinitionCollection();

        $this->fromDirectory($directory);
    }

    public function getClassDefinitions(): ClassDefinitionCollection
    {
        return $this->classDefinitionCollection;
    }

    public function getFunctionDefinitions(): FunctionDefinitionCollection
    {
        return $this->functionDefinitionCollection;
    }

    /**
     * @param $file
     * @return void
     */
    public function fromFile(\SplFileInfo $file)
    {
        $ast = AST::fromFile($file->getPathname());
        $this->classDefinitionCollection = $this->classDefinitionCollection->merge($this->nodeFinder->findInstanceOf($ast, Class_::class));
        $this->functionDefinitionCollection = $this->functionDefinitionCollection->merge($this->nodeFinder->findInstanceOf($ast,Function_::class));
    }

    public function fromDirectory(\SplFileInfo $directory)
    {
       $files = (new Finder())->files()
            ->name('*.php')
            ->exclude(['vendor', 'system'])
           ->notPath('cache')
            ->in($directory->getPathname());

        foreach ($files as $file) {
            $this->fromFile($file);
        }
    }
}
