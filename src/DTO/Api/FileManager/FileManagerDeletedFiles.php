<?php

namespace DataMat\CheshireCat\DTO\Api\FileManager;

class FileManagerDeletedFiles
{
    public bool $deleted;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'deleted' => $this->deleted,
        ];
    }
}