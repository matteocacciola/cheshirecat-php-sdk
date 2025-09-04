<?php

namespace DataMat\CheshireCat\DTO;

class Memory
{
    /** @var array<string, mixed>|null */
    public ?array $declarative = [];

    /**
     * @return array<string, null|array<string, mixed>>
     */
    public function toArray(): array
    {
        return [
            'declarative' => $this->declarative,
        ];
    }
}
