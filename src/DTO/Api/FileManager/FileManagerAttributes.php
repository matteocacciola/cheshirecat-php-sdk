<?php

namespace DataMat\CheshireCat\DTO\Api\FileManager;

use DataMat\CheshireCat\DTO\Api\FileManager\Nested\FileResponse;

class FileManagerAttributes
{
    /** @var array<FileResponse> */
    public array $files = [];

    public int $size;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'files' => array_map(fn(FileResponse $file) => $file->toArray(), $this->files),
            'size' => $this->size,
        ];
    }
}