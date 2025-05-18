<?php

namespace DataMat\CheshireCat\Tests;

use DataMat\CheshireCat\Clients\WSClient;
use DataMat\CheshireCat\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class WsClientTest extends TestCase
{
    use TestTrait;

    /**
     * @throws GuzzleException
     */
    public function testClientWithApiKey(): void
    {
        $wsClient = new WSClient('example.com', 8080, $this->apikey);
        $guzzleUri = $wsClient->getWsUri('agent', 'user');

        self::assertEquals(
            'ws://example.com:8080/ws/agent?user_id=user&apikey=' . $this->apikey,
            urldecode($guzzleUri->toString())
        );
    }

    /**
     * @throws GuzzleException
     */
    public function testClientWithToken(): void
    {
        $wsClient = new WSClient('example.com', 8080, $this->apikey);
        $wsClient->setToken($this->token);
        $guzzleUri = $wsClient->getWsUri('agent', 'user');

        self::assertEquals(
            'ws://example.com:8080/ws/agent?user_id=user&token=' . $this->token,
            urldecode($guzzleUri->toString())
        );
    }
}