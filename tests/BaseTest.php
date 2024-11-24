<?php

namespace DataMat\CheshireCat\Tests;

use DataMat\CheshireCat\Endpoints\AbstractEndpoint;
use DataMat\CheshireCat\Tests\Traits\TestTrait;
use GuzzleHttp\Client as HttpClient;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use WebSocket\Client as WsClient;

class BaseTest extends TestCase
{
    use TestTrait;

    /**
     * @throws \JsonException|Exception
     */
    public function testFailGetClientFromHttpClient(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You must provide an apikey or a token');

        $httpClient = $this->getHttpClient();
        $httpClient->getClient();
    }

    /**
     * @throws \JsonException|Exception
     */
    public function testFailGetClientFromWSClient(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You must provide an apikey or a token');

        $wsClient = $this->getWsClient();
        $wsClient->getClient();
    }

    /**
     * @throws \JsonException|Exception
     */
    public function testGetGuzzleClientsFromCheshireCatClientWithApikeySuccess(): void
    {
        $cheshireCatClient = $this->getCheshireCatClient($this->apikey);

        self::assertInstanceOf(HttpClient::class, $cheshireCatClient->getHttpClient()->getClient());
        self::assertInstanceOf(WsClient::class, $cheshireCatClient->getWsClient()->getClient());
    }

    /**
     * @throws \JsonException|Exception
     */
    public function testGetGuzzleClientsFromCheshireCatClientWithTokenSuccess(): void
    {
        $cheshireCatClient = $this->getCheshireCatClient();
        $cheshireCatClient->addToken($this->token);

        self::assertInstanceOf(HttpClient::class, $cheshireCatClient->getHttpClient()->getClient());
        self::assertInstanceOf(WsClient::class, $cheshireCatClient->getWsClient()->getClient());
    }

    /**
     * @throws Exception|\JsonException
     */
    public function testFactorySuccess(): void
    {
        $cheshireCatClient = $this->getCheshireCatClient($this->apikey);
        $endpoint = $cheshireCatClient->admins();

        self::assertInstanceOf(AbstractEndpoint::class, $endpoint);
    }
}