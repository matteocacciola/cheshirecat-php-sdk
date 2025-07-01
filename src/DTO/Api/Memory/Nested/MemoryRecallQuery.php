<?php

namespace DataMat\CheshireCat\DTO\Api\Memory\Nested;

class MemoryRecallQuery
{
    public string $text;

    /** @var float[]|float[][]|array<string, mixed> */
    public array $vector;
}
