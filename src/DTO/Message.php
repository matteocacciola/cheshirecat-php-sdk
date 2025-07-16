<?php

namespace DataMat\CheshireCat\DTO;

class Message extends MessageBase
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $metadata;

    /**
     * @param array<string, mixed>|null $metadata
     */
    public function __construct(
        string $text,
        ?string $image = null,
        ?array $metadata = null
    ) {
        $this->text = $text;
        $this->image = $image;
        $this->metadata = $metadata;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'text' => $this->text,
            'image' => $this->image,
        ];

        if ($this->metadata !== null) {
            $result['metadata'] = $this->metadata;
        }

        return $result;
    }
}
