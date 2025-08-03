<?php

namespace DataMat\CheshireCat\DTO\Api\Plugin\Settings;

class PluginSettingsOutput
{
    public string $name;

    /** @var PluginSchemaSettings|null */
    private ?PluginSchemaSettings $scheme = null;

    /** @var array<string, mixed> */
    public array $value;

    public function getScheme(): ?PluginSchemaSettings
    {
        return $this->scheme;
    }

    public function setScheme(mixed $scheme): void
    {
        if ($scheme instanceof PluginSchemaSettings) {
            $this->scheme = $scheme;
            return;
        }
        if (is_array($scheme) && !empty($scheme)) {
            $new = new PluginSchemaSettings();
            $new->title = $scheme['title'];
            $new->type = $scheme['type'];
            $new->properties = $scheme['properties'];
            $this->scheme = $new;

            return;
        }

        $this->scheme = null;
    }
}
