<?php

namespace DataMat\CheshireCat\DTO\Api\Plugin;

class PluginItemOutput
{
    public string $id;

    public string $name;

    public ?string $description = null;

    public ?string $authorName = null;

    public ?string $authorUrl = null;

    public ?string $pluginUrl = null;

    private ?string $tags = null;

    public ?string $thumb = null;

    public ?string $version = null;

    /** @var array<string, mixed> */
    public array $localInfo;

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(mixed $tags): void
    {
        if (is_array($tags)) {
            $this->tags = implode(', ', $tags);
        } else {
            $this->tags = $tags;
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'author_name' => $this->authorName,
            'author_url' => $this->authorUrl,
            'plugin_url' => $this->pluginUrl,
            'tags' => $this->getTags(),
            'thumb' => $this->thumb,
            'version' => $this->version,
            'local_info' => $this->localInfo,
        ];
    }
}
