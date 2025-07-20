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

    public ?string $tags = null;

    public ?string $thumb = null;

    public ?string $version = null;

    public bool $active;

    /** @var array<int, HookOutput> */
    public array $hooks;

    /** @var array<int, ToolOutput> */
    public array $tools;

    /** @var array<int, FormOutput> */
    public array $forms;

    /** @var array<int, EndpointOutput> */
    public array $endpoints;

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
            'tags' => $this->tags,
            'thumb' => $this->thumb,
            'version' => $this->version,
            'active' => $this->active,
            'hooks' => array_map(fn(HookOutput $item) => $item->toArray(), $this->hooks),
            'tools' => array_map(fn(ToolOutput $item) => $item->toArray(), $this->tools),
            'forms' => array_map(fn(FormOutput $item) => $item->toArray(), $this->forms),
            'endpoints' => array_map(fn(EndpointOutput $item) => $item->toArray(), $this->endpoints),
        ];
    }
}
