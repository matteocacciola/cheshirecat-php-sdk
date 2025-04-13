<?php

namespace DataMat\CheshireCat\DTO;

class Message extends MessageBase
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $additionalFields;

    /**
     * @param array<string, mixed>|null $additionalFields
     */
    public function __construct(
        string $text,
        ?string $image = null,
        ?array $additionalFields = null
    ) {
        $this->text = $text;
        $this->image = $image;
        $this->additionalFields = $additionalFields;
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

        if ($this->additionalFields !== null) {
            $result = array_merge($result, $this->additionalFields);
        }

        return $result;
    }
}
