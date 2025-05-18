<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingOutput;
use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;

class ChunkerEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/chunking';

    /**
     * This endpoint returns the settings of all chunkers.
     *
     * @throws GuzzleException
     */
    public function getChunkersSettings(string $agentId): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            $agentId,
            FactoryObjectSettingsOutput::class,
        );
    }

    /**
     * This endpoint returns the settings of a specific chunker.
     *
     * @throws GuzzleException
     */
    public function getChunkerSettings(string $chunker, string $agentId): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $chunker),
            $agentId,
            FactoryObjectSettingOutput::class,
        );
    }

    /**
     * This endpoint updates the settings of a specific chunker.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putChunkerSettings(
        string $chunker,
        string $agentId,
        array $values,
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $chunker),
            $agentId,
            FactoryObjectSettingOutput::class,
            $values,
        );
    }
}