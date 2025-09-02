<?php

namespace DataMat\CheshireCat\DTO;

class Message extends MessageBase
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $metadata;

    public bool $stream = false;

    /**
     * @param array<string, mixed>|null $metadata
     */
    public function __construct(
        string $text,
        ?string $image = null,
        ?array $metadata = null,
        bool $stream = false
    ) {
        $this->text = $text;
        $this->image = $image;
        $this->metadata = $metadata;
        $this->stream = $stream;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'text' => $this->text,
            'image' => $this->image,
            'stream' => $this->stream,
        ];

        if ($this->metadata !== null) {
            $result['metadata'] = $this->metadata;
        }

        return $result;
    }
}
