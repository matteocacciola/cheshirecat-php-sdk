<?php

namespace Albocode\CcatphpSdk\Model;

class Why
{
    public string $input;

    /**
     * @var null|array
     */
    public ?array $intermediate_steps;

    public Memory $memory;
}