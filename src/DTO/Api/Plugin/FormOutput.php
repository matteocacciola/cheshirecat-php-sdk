<?php

namespace DataMat\CheshireCat\DTO\Api\Plugin;

class FormOutput
{
    public string $name;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
