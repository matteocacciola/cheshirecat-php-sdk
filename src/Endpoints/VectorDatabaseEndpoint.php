<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingOutput;
use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;

class VectorDatabaseEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/vector_database';

    /**
     * This endpoint returns the settings of all vector databases.
     *
     * @throws GuzzleException
     */
    public function getVectorDatabasesSettings(string $agentId): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            $agentId,
            FactoryObjectSettingsOutput::class,
        );
    }

    /**
     * This endpoint returns the settings of a specific vector database.
     *
     * @throws GuzzleException
     */
    public function getVectorDatabaseSettings(string $vectorDatabase, string $agentId): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $vectorDatabase),
            $agentId,
            FactoryObjectSettingOutput::class,
        );
    }

    /**
     * This endpoint updates the settings of a specific vector database.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putVectorDatabaseSettings(
        string $vectorDatabase,
        string $agentId,
        array $values,
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $vectorDatabase),
            $agentId,
            FactoryObjectSettingOutput::class,
            $values,
        );
    }
}