<?php

namespace DataMat\CheshireCat\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Why
{
    public ?string $input;

    /** @var null|array<string, mixed> */
    #[SerializedName('intermediate_steps')]
    public ?array $intermediateSteps = [];

    public Memory $memory;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'input' => $this->input,
            'intermediate_steps' => $this->intermediateSteps,
            'memory' => $this->memory->toArray(),
        ];
    }
}
