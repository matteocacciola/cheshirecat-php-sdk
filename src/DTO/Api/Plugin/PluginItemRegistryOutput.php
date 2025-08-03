<?php

namespace DataMat\CheshireCat\DTO\Api\Plugin;

class PluginItemRegistryOutput
{
    public ?string $id = null;

    public string $name;

    public ?string $description = null;

    public ?string $authorName = null;

    public ?string $authorUrl = null;

    public ?string $pluginUrl = null;

    private ?string $tags = null;

    public ?string $thumb = null;

    public ?string $version = null;

    public ?string $url = null;

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
     * @return array<string, string>
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
            'url' => $this->url,
        ];
    }
}
