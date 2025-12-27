<?php

namespace DataMat\CheshireCat\DTO\Api\Conversation;

use Symfony\Component\Serializer\Annotation\SerializedName;

class ConversationsResponse
{
    #[SerializedName('chat_id')]
    public string $chatId;

    public string $name;

    #[SerializedName('num_messages')]
    public int $numMessages;

    #[SerializedName('created_at')]
    public float $createdAt;

    #[SerializedName('updated_at')]
    public float $updatedAt;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId,
            'name' => $this->name,
            'num_messages' => $this->numMessages,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}