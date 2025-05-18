<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingOutput;
use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingsOutput;
use DataMat\CheshireCat\DTO\Api\FileManager\FileManagerAttributes;
use GuzzleHttp\Exception\GuzzleException;

class FileManagerEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/file_manager';

    /**
     * This endpoint returns the settings of all plugin file managers.
     *
     * @throws GuzzleException
     */
    public function getFileManagersSettings(string $agentId): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            $agentId,
            FactoryObjectSettingsOutput::class,
        );
    }

    /**
     * This endpoint returns the settings of a specific plugin file manager.
     *
     * @throws GuzzleException
     */
    public function getFileManagerSettings(string $fileManager, string $agentId): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $fileManager),
            $agentId,
            FactoryObjectSettingOutput::class,
        );
    }

    /**
     * This endpoint updates the settings of a specific Plugin file manager.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putFileManagerSettings(
        string $fileManager,
        string $agentId,
        array $values,
    ): FactoryObjectSettingOutput
    {
        return $this->put(
            $this->formatUrl('/settings/' . $fileManager),
            $agentId,
            FactoryObjectSettingOutput::class,
            $values,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getFileManagerAttributes(string $agentId): FileManagerAttributes
    {
        return $this->get($this->prefix, $agentId, FileManagerAttributes::class);
    }
}