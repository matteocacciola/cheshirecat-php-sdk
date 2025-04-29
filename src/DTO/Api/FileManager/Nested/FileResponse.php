<?php

namespace DataMat\CheshireCat\DTO\Api\FileManager\Nested;

use Symfony\Component\Serializer\Annotation\SerializedName;

class FileResponse
{
    public string $path;

    public string $name;

    public int $size;

    #[SerializedName('last_modified')]
    public string $lastModified;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'path' => $this->path,
            'name' => $this->name,
            'size' => $this->size,
            'last_modified' => $this->lastModified,
        ];
    }
}