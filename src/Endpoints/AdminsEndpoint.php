<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Admins\AdminOutput;
use DataMat\CheshireCat\DTO\Api\Admins\PluginDeleteOutput;
use DataMat\CheshireCat\DTO\Api\Admins\PluginDetailsOutput;
use DataMat\CheshireCat\DTO\Api\Admins\PluginInstallFromRegistryOutput;
use DataMat\CheshireCat\DTO\Api\Admins\PluginInstallOutput;
use DataMat\CheshireCat\DTO\Api\Plugin\PluginCollectionOutput;
use DataMat\CheshireCat\DTO\Api\Plugin\PluginsSettingsOutput;
use DataMat\CheshireCat\DTO\Api\Plugin\PluginToggleOutput;
use DataMat\CheshireCat\DTO\Api\Plugin\Settings\PluginSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Utils;

class AdminsEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/admins';

    /**
     * This endpoint is used to create a new admin user in the system.
     *
     * @param array<string, mixed>|null $permissions
     *
     * @throws GuzzleException
     */
    public function postAdmin(string $username, string $password, ?array $permissions = null): AdminOutput
    {
        $payload = [
            'username' => $username,
            'password' => $password,
        ];
        if ($permissions !== null) {
            $payload['permissions'] = $permissions;
        }

        return $this->postJson(
            $this->formatUrl('/users'), $this->systemId, AdminOutput::class, $payload
        );
    }

    /**
     * This endpoint is used to get a list of admin users in the system.
     *
     * @return AdminOutput[]
     * @throws GuzzleException|\JsonException
     */
    public function getAdmins(?int $limit = null, ?int $skip = null): array
    {
        $query = [];
        if ($limit) {
            $query['limit'] = $limit;
        }
        if ($skip) {
            $query['skip'] = $skip;
        }

        $endpoint = $this->formatUrl('/users');

        $response = $this->getHttpClient($this->systemId)->get(
            $endpoint,
            $query ? ['query' => $query] : []
        );
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(
                sprintf('Failed to fetch data from endpoint %s: %s', $endpoint, $response->getReasonPhrase())
            );
        }

        $response = $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
        $result = [];
        foreach ($response as $item) {
            $result[] = $this->deserialize(
                json_encode($item, JSON_THROW_ON_ERROR), AdminOutput::class, 'json'
            );
        }
        return $result;
    }

    /**
     * This endpoint is used to get a specific admin user in the system.
     *
     * @throws GuzzleException
     */
    public function getAdmin(string $adminId): AdminOutput
    {
        return $this->get($this->formatUrl('/users/' . $adminId), $this->systemId, AdminOutput::class);
    }

    /**
     * This endpoint is used to update an admin user in the system.
     *
     * @param array<string, mixed>|null $permissions
     *
     * @throws GuzzleException
     */
    public function putAdmin(
        string $adminId,
        ?string $username = null,
        ?string $password = null,
        ?array $permissions = null,
    ): AdminOutput {
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
            $this->formatUrl('/users/' . $adminId), $this->systemId, AdminOutput::class, $payload
        );
    }

    /**
     * This endpoint is used to delete an admin user in the system.
     *
     * @throws GuzzleException
     */
    public function deleteAdmin(string $adminId): AdminOutput
    {
        return $this->delete($this->formatUrl('/users/' . $adminId), $this->systemId, AdminOutput::class);
    }

    /**
     * This endpoint returns the available plugins, at a system level.
     *
     * @throws GuzzleException
     */
    public function getAvailablePlugins(?string $pluginName = null): PluginCollectionOutput
    {
        return $this->get(
            $this->formatUrl('/plugins'),
            $this->systemId,
            PluginCollectionOutput::class,
            null,
            $pluginName ? ['query' => $pluginName] : []
        );
    }

    /**
     * This endpoint installs a plugin from a ZIP file.
     *
     * @throws GuzzleException
     */
    public function postInstallPluginFromZip(string $pathZip): PluginInstallOutput
    {
        return $this->postMultipart(
            $this->formatUrl('/plugins/upload'),
            $this->systemId,
            PluginInstallOutput::class,
            [
                [
                    'name' => 'file',
                    'contents' => Utils::tryFopen($pathZip, 'r'),
                    'filename' => basename($pathZip),
                ],
            ],
        );
    }

    /**
     * This endpoint installs a plugin from the registry.
     *
     * @throws GuzzleException
     */
    public function postInstallPluginFromRegistry(string $url): PluginInstallFromRegistryOutput
    {
        return $this->postJson(
            $this->formatUrl('/plugins/upload/registry'),
            $this->systemId,
            PluginInstallFromRegistryOutput::class,
            ['url' => $url],
        );
    }

    /**
     * This endpoint retrieves the plugins settings, i.e. the default ones at a system level.
     *
     * @throws GuzzleException
     */
    public function getPluginsSettings(): PluginsSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/plugins/settings'),
            $this->systemId,
            PluginsSettingsOutput::class,
        );
    }

    /**
     * This endpoint retrieves the plugin settings, i.e. the default ones at a system level.
     *
     * @throws GuzzleException
     */
    public function getPluginSettings(string $pluginId): PluginSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/plugins/settings/' . $pluginId),
            $this->systemId,
            PluginSettingsOutput::class,
        );
    }

    /**
     * This endpoint retrieves the plugin details, at a system level.
     *
     * @throws GuzzleException
     */
    public function getPluginDetails(string $pluginId): PluginDetailsOutput
    {
        return $this->get(
            $this->formatUrl('/plugins/' . $pluginId),
            $this->systemId,
            PluginDetailsOutput::class,
        );
    }

    /**
     * This endpoint deletes a plugin, at a system level.
     *
     * @throws GuzzleException
     */
    public function deletePlugin(string $pluginId): PluginDeleteOutput
    {
        return $this->delete(
            $this->formatUrl('/plugins/' . $pluginId),
            $this->systemId,
            PluginDeleteOutput::class,
        );
    }

    /**
     * This endpoint toggles a plugin.
     *
     * @throws GuzzleException
     */
    public function putTogglePlugin(string $pluginId): PluginToggleOutput
    {
        return $this->put(
            $this->formatUrl('/plugins/toggle/' . $pluginId),
            $this->systemId,
            PluginToggleOutput::class,
        );
    }
}