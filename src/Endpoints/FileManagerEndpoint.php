<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingOutput;
use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;

class FileManagerEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/file_manager';

    /**
     * This endpoint returns the settings of all plugin file managers. Plugin file managers are set to a system level,
     * so usable by all the agents in the system.
     *
     * @throws GuzzleException
     */
    public function getFileManagersSettings(): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $this->systemId,
        );
    }

    /**
     * This endpoint returns the settings of a specific plugin file manager. Plugin file managers are set to a system
     * level, so usable by all the agents in the system.
     *
     * @throws GuzzleException
     */
    public function getFileManagerSettings(string $fileManager): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $fileManager),
            FactoryObjectSettingOutput::class,
            $this->systemId,
        );
    }

    /**
     * This endpoint updates the settings of a specific Plugin file manager. Plugin file managers are set to a system
     * level, so usable by all the agents in the system.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putFileManagerSettings(string $fileManager, array $values): FactoryObjectSettingOutput
    {
        return $this->put(
            $this->formatUrl('/settings/' . $fileManager),
            FactoryObjectSettingOutput::class,
            $values,
            $this->systemId,
        );
    }
}