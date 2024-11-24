<?php

namespace DataMat\CheshireCat\DTO\Api\Memory;

use DataMat\CheshireCat\DTO\Api\Memory\Nested\Record;

class MemoryPointsOutput
{
    /** @var Record[] */
    public array $points;

    public string|int|null $nextOffset = null;
}