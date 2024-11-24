<?php

namespace DataMat\CheshireCat\DTO\Api\Memory;

use DataMat\CheshireCat\DTO\MemoryPoint;

class MemoryPointOutput extends MemoryPoint
{
    public string $id;

    /** @var float[] */
    public array $vector;

}