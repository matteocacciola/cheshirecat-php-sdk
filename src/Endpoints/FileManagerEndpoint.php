<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingOutput;
use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;

class FileManagerEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/file_manager';

    /**
     * This endpoint returns the settings of all plugin file managers, either for the agent identified by the agentId
     *  parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getFileManagersSettings(?string $agentId = null): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint returns the settings of a specific plugin file manager, either for the agent identified by the agentId
     *  parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getFileManagerSettings(string $fileManager, ?string $agentId = null): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $fileManager),
            FactoryObjectSettingOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint updates the settings of a specific Plugin file manager, either for the agent identified by the agentId
     *   parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putFileManagerSettings(
        string $fileManager,
        array $values,
        ?string $agentId = null,
    ): FactoryObjectSettingOutput
    {
        return $this->put(
            $this->formatUrl('/settings/' . $fileManager),
            FactoryObjectSettingOutput::class,
            $values,
            $agentId,
        );
    }
}