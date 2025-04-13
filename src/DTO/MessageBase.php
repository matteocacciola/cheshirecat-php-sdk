<?php

namespace DataMat\CheshireCat\DTO;

class MessageBase
{
    public string $text;

    /** @var string|null  */
    public ?string $image = null;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'text' => $this->text,
        ];

        if ($this->image !== null) {
            $result['image'] = $this->image;
        }

        return $result;
    }
}