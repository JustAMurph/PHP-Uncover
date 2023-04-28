<?php

namespace App\Plugins\Symfony;

use App\RouteParser\IParseRoutes;
use App\RouteParser\Route;
use App\RouteParser\RouteCollection;
use App\Utility\AST;
use App\Utility\EnhancedNodeFinder;
use PhpParser\Comment\Doc;
use PhpParser\Node\Stmt\ClassMethod;
use Symfony\Component\Finder\Finder;

class AnnotationRouteParser implements IParseRoutes
{
    public function parse(\SplFileInfo $directory): RouteCollection
    {
        $controllers = (new Finder())
            ->path('src/Controller')
            ->name('*.php')
            ->in($directory->getPathname());

        $nodeFinder = new EnhancedNodeFinder();
        $result = new RouteCollection();

        foreach($controllers as $path)
        {
            $ast = AST::fromFile($path->getPathname());
            $methods = $nodeFinder->find($ast, $this->findAnnotations(...));

            $result = $result->merge(
                $this->entryPointsFromClassMethods($methods)
            );
        }

        return $result;
    }

    private function entryPointsFromClassMethods($methods)
    {
        $result = new RouteCollection();
        foreach($methods as $item) {
            $result->push($this->entryPointFromClassMethod($item));
        }
        return $result;
    }

    private function entryPointFromClassMethod(ClassMethod $method)
    {
        $ep = new Route($method);
        $ep->addUrl($this->getRouteFromComments($method->getAttribute('comments')));
        return $ep;
    }

    private function findAnnotations($node)
    {
        if (!$node instanceof ClassMethod) {
            return;
        }

        return (bool) $this->getRouteFromComments($node->getAttribute('comments'));
    }

    private function getRouteFromComments($comments)
    {
        if (!$comments) {
            return;
        }

        foreach($comments as $comment) {
            if ($url = $this->getRouteURL($comment)) {
                return $url;
            }
        }
    }

    /**
     * Fix for comments while parsing PHP7
     *
     * @param Doc $doc
     * @return bool
     */
    private function getRouteURL(Doc $doc)
    {
        $matches = [];
        $found = preg_match("/@Route\([\"']([-\w\/{}]*)/", $doc->getText(), $matches);
        if ($found) {
            return $matches[1];
        }
    }
}
