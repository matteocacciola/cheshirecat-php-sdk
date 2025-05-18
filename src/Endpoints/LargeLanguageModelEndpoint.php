<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingOutput;
use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingsOutput;
use GuzzleHttp\Exception\GuzzleException;

class LargeLanguageModelEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/llm';

    /**
     * This endpoint returns the settings of all large language models.
     *
     * @throws GuzzleException
     */
    public function getLargeLanguageModelsSettings(string $agentId): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            $agentId,
            FactoryObjectSettingsOutput::class,
        );
    }

    /**
     * This endpoint returns the settings of a specific large language model.
     *
     * @throws GuzzleException
     */
    public function getLargeLanguageModelSettings(string $llm, string $agentId): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $llm),
            $agentId,
            FactoryObjectSettingOutput::class,
        );
    }

    /**
     * This endpoint updates the settings of a specific large language model.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putLargeLanguageModelSettings(
        string $llm,
        string $agentId,
        array $values,
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $llm),
            $agentId,
            FactoryObjectSettingOutput::class,
            $values,
        );
    }
}