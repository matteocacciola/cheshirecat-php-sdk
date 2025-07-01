<?php

namespace DataMat\CheshireCat\DTO\Api\Memory\Nested;

class Record
{
    public string $id;

    /** @var array<string, mixed>|null  */
    public ?array $payload;

    /** @var float[]|float[][]|array<string, mixed>|null  */
    public ?array $vector;

    public ?string $shardKey;

    public ?float $orderValue;
}
