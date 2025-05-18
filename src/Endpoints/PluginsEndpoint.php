<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Plugin\PluginCollectionOutput;
use DataMat\CheshireCat\DTO\Api\Plugin\PluginsSettingsOutput;
use DataMat\CheshireCat\DTO\Api\Plugin\PluginToggleOutput;
use DataMat\CheshireCat\DTO\Api\Plugin\Settings\PluginSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;

class PluginsEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/plugins';

    /**
     * This endpoint returns the available plugins.
     *
     * @throws GuzzleException
     */
    public function getAvailablePlugins(string $agentId, ?string $pluginName = null): PluginCollectionOutput
    {
        return $this->get(
            $this->prefix,
            $agentId,
            PluginCollectionOutput::class,
            null,
            $pluginName ? ['query' => $pluginName] : []
        );
    }

    /**
     * This endpoint toggles a plugin.
     *
     * @throws GuzzleException
     */
    public function putTogglePlugin(string $pluginId, string $agentId): PluginToggleOutput
    {
        return $this->put(
            $this->formatUrl('/toggle/' . $pluginId),
            $agentId,
            PluginToggleOutput::class,
        );
    }

    /**
     * This endpoint retrieves the plugins settings.
     *
     * @throws GuzzleException
     */
    public function getPluginsSettings(string $agentId): PluginsSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            $agentId,
            PluginsSettingsOutput::class,
        );
    }

    /**
     * This endpoint retrieves the plugin settings.
     *
     * @throws GuzzleException
     */
    public function getPluginSettings(string $pluginId, string $agentId): PluginSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $pluginId),
            $agentId,
            PluginSettingsOutput::class,
        );
    }

    /**
     * This endpoint updates the plugin settings.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putPluginSettings(string $pluginId, string $agentId, array $values): PluginSettingsOutput
    {
        return $this->put(
            $this->formatUrl('/settings/' . $pluginId),
            $agentId,
            PluginSettingsOutput::class,
            $values,
        );
    }
}