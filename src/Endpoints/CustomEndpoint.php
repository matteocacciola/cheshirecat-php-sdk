<?php

namespace DataMat\CheshireCat\Endpoints;

use GuzzleHttp\Exception\GuzzleException;

class CustomEndpoint extends AbstractEndpoint
{
    /**
     * This method is used to trigger a custom endpoint with a GET method
     *
     * @param array<string, mixed>|null $query
     *
     * @return array<int|string, mixed>
     * @throws GuzzleException
     */
    public function getCustom(string $url, string $agentId, ?string $userId = null, ?array $query = null): array
    {
        return $this->get($url, $agentId, 'json', $userId, $query);
    }

    /**
     * This method is used to trigger a custom endpoint with a POST method
     *
     * @return array<int|string, mixed>
     * @throws GuzzleException
     */
    public function postCustom(
        string $url,
        string $agentId,
        ?array $payload = null,
        ?string $userId = null,
    ): array {
        return $this->postJson($url, $agentId, 'json', $payload, $userId);
    }

    /**
     * This method is used to trigger a custom endpoint with a PUT method
     *
     * @return array<int|string, mixed>
     * @throws GuzzleException|\JsonException
     */
    public function putCustom(
        string $url,
        string $agentId,
        ?array $payload = null,
        ?string $userId = null,
    ): array {
        return $this->put($url, $agentId, 'json', $payload, $userId);
    }

    /**
     * This method is used to trigger a custom endpoint with a DELETE method
     *
     * @return array<int|string, mixed>
     *
     * @throws GuzzleException
     */
    public function deleteCustom(
        string $url,
        string $agentId,
        ?array $payload = null,
        ?string $userId = null,
    ): array {
        return $this->delete($url, $agentId, 'json', $payload, $userId);
    }
}