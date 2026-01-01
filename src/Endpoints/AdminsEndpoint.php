<?php

namespace DataMat\CheshireCat\Endpoints;

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
    protected string $prefix = '/plugins';

    /**
     * This endpoint returns the available plugins, at a system level.
     *
     * @throws GuzzleException
     */
    public function getAvailablePlugins(?string $pluginName = null): PluginCollectionOutput
    {
        return $this->get(
            $this->formatUrl('/installed'),
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
            $this->formatUrl('/install/upload'),
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
            $this->formatUrl('/install/registry'),
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
            $this->formatUrl('/system/settings'),
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
            $this->formatUrl('/system/settings/' . $pluginId),
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
            $this->formatUrl('/system/details/' . $pluginId),
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
            $this->formatUrl('/uninstall/' . $pluginId),
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
            $this->formatUrl('/system/toggle/' . $pluginId),
            $this->systemId,
            PluginToggleOutput::class,
        );
    }
}