<?php

namespace DataMat\CheshireCat\DTO\Api\Message;

use DataMat\CheshireCat\DTO\MessageBase;
use DataMat\CheshireCat\DTO\Why;

class MessageOutput extends MessageBase
{
    public ?string $type = 'chat';

    public ?Why $why = null;

    public ?bool $error = false;

    /** @deprecated */
    public readonly string $content;

    public function __construct(public string $text = '', public ?string $image = null)
    {
        $this->content = $text;
    }

    public function getContent(): string
    {
        return $this->text;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        $data['type'] = $this->type;
        $data['why'] = $this->why?->toArray();
        $data['content'] = $this->text;
        $data['error'] = $this->error;

        return $data;
    }
}
