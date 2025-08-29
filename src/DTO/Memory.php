<?php

namespace DataMat\CheshireCat\DTO;

class Memory
{
    /** @var array<string, mixed>|null */
    public ?array $declarative = [];

    /** @var array<string, mixed>|null */
    public ?array $procedural = [];

    /**
     * @return array<string, null|array<string, mixed>>
     */
    public function toArray(): array
    {
        return [
            'declarative' => $this->declarative,
            'procedural' => $this->procedural,
        ];
    }
}
