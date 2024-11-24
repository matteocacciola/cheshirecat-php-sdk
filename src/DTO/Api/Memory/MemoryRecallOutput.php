<?php

namespace DataMat\CheshireCat\DTO\Api\Memory;


use DataMat\CheshireCat\DTO\Api\Memory\Nested\MemoryRecallQuery;
use DataMat\CheshireCat\DTO\Api\Memory\Nested\MemoryRecallVectors;

class MemoryRecallOutput
{
    /** @var MemoryRecallQuery */
    public MemoryRecallQuery $query;

    /** @var MemoryRecallVectors */
    public MemoryRecallVectors $vectors;
}