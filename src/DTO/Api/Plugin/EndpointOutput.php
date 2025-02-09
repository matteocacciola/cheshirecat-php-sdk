<?php

namespace DataMat\CheshireCat\DTO\Api\Plugin;

class EndpointOutput
{
    public string $name;

    /** @var string[] $tags */
    public array $tags;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'tags' => $this->tags,
        ];
    }
}
