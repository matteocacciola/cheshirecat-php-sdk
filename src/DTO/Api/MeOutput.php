<?php

namespace DataMat\CheshireCat\DTO\Api;

use Symfony\Component\Serializer\Annotation\SerializedName;

class MeOutput
{
    public bool $success;

    /** @var AgentMatchOutput[] $agents */
    public array $agents;

    #[SerializedName('auto_selected')]
    public bool $autoSelected;
}