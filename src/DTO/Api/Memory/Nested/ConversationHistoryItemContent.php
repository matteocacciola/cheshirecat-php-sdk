<?php

namespace DataMat\CheshireCat\DTO\Api\Memory\Nested;

use DataMat\CheshireCat\DTO\MessageBase;
use DataMat\CheshireCat\DTO\Why;

class ConversationHistoryItemContent extends MessageBase
{
    public string $text;

    public ?string $image = null;

    /** @var Why|null */
    public ?Why $why = null;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if ($this->why !== null) {
            $data['why'] = $this->why->toArray();
        }

        return $data;
    }
}