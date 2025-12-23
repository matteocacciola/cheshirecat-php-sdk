<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\TokenOutput;
use GuzzleHttp\Exception\GuzzleException;

class AuthEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/auth';

    /**
     * This endpoint is used to get a token for the user. The token is used to authenticate the user in the system. When
     * the token expires, the user must request a new token.
     *
     * @throws GuzzleException
     */
    public function token(string $username, string $password, ?string $agentId = null): TokenOutput
    {
        $headers = [];
        if ($agentId !== null) {
            $headers['X-Agent-ID'] = $agentId;
        }

        $httpClient = $this->client->getHttpClient()->createHttpClient();

        $response = $httpClient->post($this->formatUrl('/token'), [
            'json' => [
                'username' => $username,
                'password' => $password,
            ],
            'headers' => $headers,
        ]);

        /** @var TokenOutput $result */
        $result = $this->deserialize($response->getBody()->getContents(), TokenOutput::class);

        $this->client->addToken($result->accessToken);

        return $result;
    }

    /**
     * This endpoint is used to get a list of available permissions in the system. The permissions are used to define
     * the access rights of the users in the system. The permissions are defined by the system administrator.
     *
     * @return array<int|string, mixed>
     * @throws GuzzleException
     */
    public function getAvailablePermissions(): array
    {
        $endpoint = $this->formatUrl('/available-permissions');
        $response = $this->getHttpClient()->get($endpoint);
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(
                sprintf('Failed to fetch data from endpoint %s: %s', $endpoint, $response->getReasonPhrase())
            );
        }

        return $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
    }
}