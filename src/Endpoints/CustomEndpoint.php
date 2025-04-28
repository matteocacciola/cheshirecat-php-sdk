<?php

namespace DataMat\CheshireCat\Endpoints;

use GuzzleHttp\Exception\GuzzleException;

class CustomEndpoint extends AbstractEndpoint
{
    /**
     * This method is used to trigger a custom endpoint with a GET method
     *
     * @return array<int|string, mixed>
     * @throws GuzzleException
     */
    public function getCustom(string $url, ?string $agentId = null, ?string $userId = null): array
    {
        return $this->get($url, 'json', $agentId, $userId);
    }

    /**
     * This method is used to trigger a custom endpoint with a POST method
     *
     * @return array<int|string, mixed>
     * @throws GuzzleException
     */
    public function postCustom(
        string $url,
        ?array $payload = null,
        ?string $agentId = null,
        ?string $userId = null,
    ): array {
        return $this->postJson($url, 'json', $payload, $agentId, $userId);
    }

    /**
     * This method is used to trigger a custom endpoint with a PUT method
     *
     * @return array<int|string, mixed>
     * @throws GuzzleException|\JsonException
     */
    public function putCustom(
        string $url,
        ?array $payload = null,
        ?string $agentId = null,
        ?string $userId = null,
    ): array {
        return $this->put($url, 'json', $payload, $agentId, $userId);
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
        ?array $payload = null,
        ?string $agentId = null,
        ?string $userId = null,
    ): array {
        return $this->delete($url, 'json', $payload, $agentId, $userId);
    }
}