<?php

namespace DataMat\CheshireCat\DTO\Api\Message;

use DataMat\CheshireCat\DTO\MessageBase;
use DataMat\CheshireCat\DTO\Why;

class MessageOutput extends MessageBase
{
    public ?string $type = 'chat';

    public ?Why $why = null;

    public ?bool $error = false;

    public string $text;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        $data['type'] = $this->type;
        $data['why'] = $this->why?->toArray();
        $data['text'] = $this->text;
        $data['error'] = $this->error;

        return $data;
    }
}
