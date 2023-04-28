<?php

namespace App\Signature;

trait UsesSignatures
{
    protected IMatchCallLike $signature;

    public function setSignature(...$args): static
    {
        $this->signature = new Signature(...$args);
        return $this;
    }

    public static function withSignature(...$args)
    {
        $obj = new static();
        $obj->setSignature(...$args);
        return $obj;
    }

    public function setSignatureInstance(IMatchCallLike $match)
    {
        $this->signature = $match;
        return $this;
    }
}
