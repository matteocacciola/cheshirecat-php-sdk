<?php

namespace DataMat\CheshireCat\DTO\Api\Message;

use Symfony\Component\Serializer\Annotation\SerializedName;

class ChatOutput
{
    #[SerializedName('agent_id')]
    public string $agentId;

    #[SerializedName('user_id')]
    public string $userId;

    #[SerializedName('chat_id')]
    public string $chatId;

    public MessageOutput $message;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'agent_id' => $this->agentId,
            'user_id' => $this->userId,
            'chat_id' => $this->chatId,
            'message' => $this->message->toArray(),
        ];
    }
}
