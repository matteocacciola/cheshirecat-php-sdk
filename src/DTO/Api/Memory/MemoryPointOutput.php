<?php

namespace DataMat\CheshireCat\DTO\Api\Memory;

use DataMat\CheshireCat\DTO\MemoryPoint;

class MemoryPointOutput extends MemoryPoint
{
    public string $id;

    /** @var float[]|float[][]|array<string, mixed> */
    public array $vector;

}