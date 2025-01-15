<?php

namespace DataMat\CheshireCat\Builders;

interface BaseBuilder
{
    public static function create(): self;

    public function build(): mixed;
}