<?php

namespace DataMat\CheshireCat\DTO\Api;

use Symfony\Component\Serializer\Annotation\SerializedName;

class AgentMatchOutput
{
    #[SerializedName('agent_id')]
    public string $agentId;

    #[SerializedName('agent_name')]
    public string $agentName;

    #[SerializedName('agent_description')]
    public ?string $agentDescription = null;

    public UserMeOutput $user;
}