<?php

namespace DataMat\CheshireCat;

use DataMat\CheshireCat\Endpoints\AbstractEndpoint;

class CheshireCatFactory
{
    public static function build(string $class, CheshireCatClient $client): AbstractEndpoint
    {
        if (!class_exists($class)) {
            throw new \BadMethodCallException();
        }

        return new $class($client);
    }
}
