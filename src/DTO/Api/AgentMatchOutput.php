<?php

namespace DataMat\CheshireCat\DTO\Api;

use Symfony\Component\Serializer\Annotation\SerializedName;

class AgentMatchOutput
{
    #[SerializedName('agent_name')]
    public string $agentName;

    public UserMeOutput $user;
}