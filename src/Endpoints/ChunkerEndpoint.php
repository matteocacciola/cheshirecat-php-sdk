<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingOutput;
use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;

class ChunkerEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/chunking';

    /**
     * This endpoint returns the settings of all chunkers, either for the agent identified by the agentId
     * parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getChunkersSettings(?string $agentId = null): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            FactoryObjectSettingsOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint returns the settings of a specific chunker, either for the agent identified by the
     * agentId parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @throws GuzzleException
     */
    public function getChunkerSettings(string $chunker, ?string $agentId = null): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $chunker),
            FactoryObjectSettingOutput::class,
            $agentId,
        );
    }

    /**
     * This endpoint updates the settings of a specific chunker, either for the agent identified by the
     * agentId parameter (for multi-agent installations) or for the default agent (for single-agent installations).
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putChunkerSettings(
        string $chunker,
        array $values,
        ?string $agentId = null,
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $chunker),
            FactoryObjectSettingOutput::class,
            $values,
            $agentId,
        );
    }
}