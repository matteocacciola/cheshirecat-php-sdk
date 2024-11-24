<?php

namespace DataMat\CheshireCat\DTO\Api\Plugin\Settings;

class PropertySettingsOutput
{
    public mixed $default = null;

    /** @var array<string, mixed>|null */
    public ?array $extra = null;

    public string $title;

    public string $type;

}
