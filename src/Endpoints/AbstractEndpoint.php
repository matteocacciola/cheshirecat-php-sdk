<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\CheshireCatClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use WebSocket\Client as WebSocketClient;

abstract class AbstractEndpoint
{
    protected CheshireCatClient $client;
    protected string $prefix;

    protected string $systemId = 'system';

    public function __construct(CheshireCatClient $client)
    {
        $this->client = $client;
    }

    protected function formatUrl(string $endpoint): string
    {
        return str_replace('//', '/', sprintf('/%s/%s', $this->prefix, $endpoint));
    }

    protected function getHttpClient(?string $agentId = null, ?string $userId = null): Client
    {
        return $this->client->getHttpClient()->getClient($agentId, $userId);
    }

    protected function getWsClient(string $agentId, string $userId): WebSocketClient
    {
        return $this->client->getWsClient()->getClient($agentId, $userId);
    }

    /**
     * @param array<string, mixed> $context
     */
    protected function deserialize(string $data, string $class, ?string $format = null, ?array $context = null): mixed
    {
        $format = $format ?? 'json';
        $context = $context ?? [];

        return $this->client->getSerializer()->deserialize($data, $class, $format, $context);
    }

    /**
     * @param array<string, mixed>|null $query
     *
     * @throws GuzzleException
     */
    protected function get(
        string $endpoint,
        string $agentId,
        ?string $outputClass = null,
        ?string $userId = null,
        ?array $query = null,
    ): mixed {
        $options = [];
        if ($query) {
            $options['query'] = $query;
        }

        $response = $this->getHttpClient($agentId, $userId)->get($endpoint, $options);

        if ($outputClass === null) {
            return $response->getBody()->getContents();
        }

        return $this->deserialize($response->getBody()->getContents(), $outputClass);
    }

    /**
     * @param array<string, mixed>|null $payload
     *
     * @throws GuzzleException
     */
    protected function postJson(
        string $endpoint,
        string $agentId,
        string $outputClass,
        ?array $payload = null,
        ?string $userId = null,
    ): mixed {
        $options = [];
        if ($payload) {
            $options['json'] = $payload;
        }

        $response = $this->getHttpClient($agentId, $userId)->post($endpoint, $options);

        return $this->deserialize($response->getBody()->getContents(), $outputClass);
    }

    /**
     * @param array<int, array<string, mixed>>|null $payload
     *
     * @throws GuzzleException
     */
    protected function postMultipart(
        string $endpoint,
        string $agentId,
        string $outputClass,
        ?array $payload = null,
        ?string $userId = null,
    ): mixed {
        $options = [];
        if ($payload) {
            $options['multipart'] = $payload;
        }

        $response = $this->getHttpClient($agentId, $userId)->post($endpoint, $options);

        return $this->deserialize($response->getBody()->getContents(), $outputClass);
    }

    /**
     * @param array<string, mixed> $payload
     *
     * @throws GuzzleException
     */
    protected function put(
        string $endpoint,
        string $agentId,
        string $outputClass,
        ?array $payload = null,
        ?string $userId = null,
    ): mixed {
        $options = [];
        if ($payload) {
            $options['json'] = $payload;
        }

        $response = $this->getHttpClient($agentId, $userId)->put($endpoint, $options);

        return $this->deserialize($response->getBody()->getContents(), $outputClass);
    }

    /**
     * @param array<string, mixed>|null $payload
     *
     * @throws GuzzleException
     */
    protected function delete(
        string $endpoint,
        string $agentId,
        string $outputClass,
        ?string $userId = null,
        ?array $payload = null,
    ): mixed {
        $options = [];
        if ($payload) {
            $options['json'] = $payload;
        }

        $response = $this->getHttpClient($agentId, $userId)->delete($endpoint, $options);

        return $this->deserialize($response->getBody()->getContents(), $outputClass);
    }
}