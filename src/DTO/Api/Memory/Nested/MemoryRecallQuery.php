<?php

namespace DataMat\CheshireCat\DTO\Api\Memory\Nested;

class MemoryRecallQuery
{
    public string $text;

    /** @var float[] */
    public array $vector;
}
