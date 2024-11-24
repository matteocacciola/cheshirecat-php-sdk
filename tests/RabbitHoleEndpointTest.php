<?php

namespace DataMat\CheshireCat\Tests;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;

class RabbitHoleEndpointTest extends BaseTest
{
    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetAllowedMimeTypesSuccess(): void
    {
        $expected = ['allowed' => ['application/pdf', 'text/plain', 'text/markdown', 'text/html']];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->rabbitHole();
        $result = $endpoint->getAllowedMimeTypes();

        self::assertEquals($expected['allowed'], $result->allowed);
    }

}