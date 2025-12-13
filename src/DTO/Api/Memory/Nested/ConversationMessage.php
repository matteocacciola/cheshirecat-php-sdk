<?php

namespace DataMat\CheshireCat\DTO\Api\Memory\Nested;

class ConversationMessage
{
    public string $who;

    public float $when;

    public ConversationHistoryItemContent $content;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'who' => $this->who,
            'content' => $this->content->toArray(),
            'when' => $this->when,
        ];
    }
}