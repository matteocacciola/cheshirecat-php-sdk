<?php

namespace DataMat\CheshireCat\Builders;

use DataMat\CheshireCat\DTO\Memory;

class MemoryBuilder implements BaseBuilder
{
    /** @var array<string, mixed>|null */
    private ?array $declarative = [];


    public static function create() : MemoryBuilder
    {
        return new self();
    }

    /**
     * @param array<string, mixed> $declarative
     */
    public function setDeclarative(?array $declarative = null): MemoryBuilder
    {
        $this->declarative = $declarative ?? [];

        return $this;
    }

    public function build(): Memory
    {
        $memory = new Memory();
        $memory->declarative = $this->declarative;

        return $memory;
    }
}