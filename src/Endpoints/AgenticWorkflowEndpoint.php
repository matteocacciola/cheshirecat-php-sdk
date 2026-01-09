<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingOutput;
use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingsOutput;
use DataMat\CheshireCat\DTO\SettingInput;
use GuzzleHttp\Exception\GuzzleException;

class AgenticWorkflowEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/agentic_workflow';

    /**
     * This endpoint returns the settings of all the agentic workflows. It is used to get the settings of all the
     * agentic workflows that are available in the agent specified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function getAgenticWorkflowsSettings(string $agentId): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            $agentId,
            FactoryObjectSettingsOutput::class,
        );
    }

    /**
     * This endpoint returns the settings of a specific agentic workflow. It is used to get the settings of a
     * specific agentic workflow that is available in the agent specified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function getAgenticWorkflowSettings(string $agenticWorkflow, string $agentId): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $agenticWorkflow),
            $agentId,
            FactoryObjectSettingOutput::class,
        );
    }

    /**
     * This endpoint updates the settings of a specific agentic workflow. It is used to update the settings of a
     * specific agentic workflow that is available in the agent specified by the agentId parameter.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putAgenticWorkflowSettings(
        string $agenticWorkflow,
        string $agentId,
        array $values,
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $agenticWorkflow),
            $agentId,
            FactoryObjectSettingOutput::class,
            $values,
        );
    }
}