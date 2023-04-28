<?php

namespace App\Output;

interface IHandleOutput
{
    public function output(): string;
    public function write(\SplFileInfo $path):bool;
}
