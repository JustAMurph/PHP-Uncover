<?php

namespace App\Source\CausesTaint;

use App\Parser\VariableContext;
use App\Signature\UsesSignatures;
use App\Source\Metadata;
use PhpParser\Node\Expr;
use PhpParser\PrettyPrinter\Standard;

class MethodCall implements IIntroduceSourceByCallLike
{
    use UsesSignatures;

    public function isSourceCallLike(Expr\CallLike $callLike, VariableContext $context = null): bool
    {
        return $this->signature->matches($callLike);
    }

    public function createMetaFromCallLike(Expr\Variable $key, Expr\CallLike $callLike): Metadata
    {
        $printer = resolve(Standard::class);

        return new Metadata($key->name, $printer->prettyPrint([$callLike]));
    }

    public function description(): string
    {
        // TODO: Implement description() method.
    }
}
