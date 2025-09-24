<?php

namespace DataMat\CheshireCat\DTO\Api\Conversation;

use DataMat\CheshireCat\DTO\Api\Memory\Nested\ConversationHistoryItem;

class ConversationHistoryOutput
{
    /** @var ConversationHistoryItem[] */
    public array $history;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $history = [];
        foreach ($this->history as $h) {
            $history[] = $h->toArray();
        }

        return ['history' => $history];
    }
}