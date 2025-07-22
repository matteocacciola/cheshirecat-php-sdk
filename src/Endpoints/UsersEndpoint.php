<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\TokenOutput;
use DataMat\CheshireCat\DTO\Api\User\UserOutput;
use GuzzleHttp\Exception\GuzzleException;

class UsersEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/users';

    /**
     * This endpoint is used to get a token for the user. The token is used to authenticate the user in the system. When
     * the token expires, the user must request a new token.
     *
     * @throws GuzzleException
     */
    public function token(string $username, string $password): TokenOutput
    {
        $httpClient = $this->client->getHttpClient()->createHttpClient();

        $response = $httpClient->post('/auth/token', [
            'json' => [
                'username' => $username,
                'password' => $password,
            ],
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
        $endpoint = '/auth/available-permissions';
        $response = $this->getHttpClient()->get($endpoint);
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(
                sprintf('Failed to fetch data from endpoint %s: %s', $endpoint, $response->getReasonPhrase())
            );
        }

        return $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
    }

    /**
     * This endpoint is used to create a new user in the system. The user is created with the specified username and
     * password. The user is assigned the specified permissions. The permissions are used to define the access rights
     * of the user in the system and are defined by the system administrator.
     *
     * @param array<string, mixed>|null $permissions
     *
     * @throws GuzzleException
     */
    public function postUser(
        string $agentId,
        string $username,
        string $password,
        ?array $permissions = null,
    ): UserOutput {
        $payload = [
            'username' => $username,
            'password' => $password,
        ];
        if ($permissions !== null) {
            $payload['permissions'] = $permissions;
        }

        return $this->postJson(
            $this->prefix,
            $agentId,
            UserOutput::class,
            $payload,
        );
    }

    /**
     * This endpoint is used to get a list of users in the system. The list includes the username and the permissions of
     * each user. The permissions are used to define the access rights of the users in the system and are defined by the
     * system administrator.
     *
     * @return UserOutput[]
     * @throws GuzzleException|\JsonException
     */
    public function getUsers(?string $agentId = null): array
    {
        $response = $this->getHttpClient($agentId)->get($this->prefix);
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(
                sprintf('Failed to fetch data from endpoint %s: %s', $this->prefix, $response->getReasonPhrase())
            );
        }

        $response = $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
        $result = [];
        foreach ($response as $item) {
            $result[] = $this->deserialize(
                json_encode($item, JSON_THROW_ON_ERROR), UserOutput::class, 'json'
            );
        }
        return $result;
    }

    /**
     * This endpoint is used to get a user in the system. The user is identified by the userId parameter, previously
     * provided by the CheshireCat API when the user was created. The endpoint returns the username and the permissions
     * of the user. The permissions are used to define the access rights of the user in the system and are defined by
     * the system administrator.
     *
     * @throws GuzzleException
     */
    public function getUser(string $userId, string $agentId): UserOutput
    {
        return $this->get(
            $this->formatUrl($userId),
            $agentId,
            UserOutput::class,
        );
    }

    /**
     * The endpoint is used to update the user in the system. The user is identified by the userId parameter, previously
     * provided by the CheshireCat API when the user was created. The endpoint updates the username, the password, and
     * the permissions of the user. The permissions are used to define the access rights of the user in the system and
     * are defined by the system administrator.
     *
     * @param array<string, mixed>|null $permissions
     *
     * @throws GuzzleException
     */
    public function putUser(
        string $userId,
        string $agentId,
        ?string $username = null,
        ?string $password = null,
        ?array $permissions = null,
    ): UserOutput {
        $payload = [];
        if ($username !== null) {
            $payload['username'] = $username;
        }
        if ($password !== null) {
            $payload['password'] = $password;
        }
        if ($permissions !== null) {
            $payload['permissions'] = $permissions;
        }

        return $this->put(
            $this->formatUrl($userId),
            $agentId,
            UserOutput::class,
            $payload,
        );
    }

    /**
     * This endpoint is used to delete the user in the system. The user is identified by the userId parameter,
     * previously provided by the CheshireCat API when the user was created.
     *
     * @throws GuzzleException
     */
    public function deleteUser(string $userId, string $agentId): UserOutput
    {
        return $this->delete(
            $this->formatUrl($userId),
            $agentId,
            UserOutput::class,
        );
    }
}