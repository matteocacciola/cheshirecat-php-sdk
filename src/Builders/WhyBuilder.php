<?php

namespace DataMat\CheshireCat\Builders;

use DataMat\CheshireCat\DTO\Memory;
use DataMat\CheshireCat\DTO\Why;

class WhyBuilder implements BaseBuilder
{
    private ?string $input;

    /** @var null|array<string, mixed> */
    private ?array $intermediateSteps = [];

    private Memory $memory;

    public static function create() : WhyBuilder
    {
        return new self();
    }

    public function setInput(?string $input): WhyBuilder
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @param array<string, mixed> $intermediateSteps
     */
    public function setIntermediateSteps(?array $intermediateSteps = null): WhyBuilder
    {
        $this->intermediateSteps = $intermediateSteps ?? [];

        return $this;
    }

    public function setMemory(Memory $memory): WhyBuilder
    {
        $this->memory = $memory;

        return $this;
    }

    public function build(): Why
    {
        $why = new Why();
        $why->input = $this->input;
        $why->intermediateSteps = $this->intermediateSteps;
        $why->memory = $this->memory;

        return $why;
    }
}