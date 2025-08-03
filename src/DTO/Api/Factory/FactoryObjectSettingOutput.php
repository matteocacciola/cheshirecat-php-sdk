<?php

namespace DataMat\CheshireCat\DTO\Api\Factory;

class FactoryObjectSettingOutput
{
    public string $name;

    /** @var array<string, mixed> */
    public array $value;

    /** @var array<string, mixed>|null */
    private ?array $scheme = null;

    /**
     * @return array<string, mixed>|null
     */
    public function getScheme(): ?array
    {
        return $this->scheme;
    }

    public function setScheme(mixed $scheme): void
    {
        if (is_array($scheme) && !empty($scheme)) {
            $this->scheme = $scheme;
            return;
        }
        if ($scheme instanceof \stdClass) {
            $this->scheme = (array) $scheme;
            return;
        }
        $this->scheme = null;
    }
}
