<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Admins\ClonedOutput;
use DataMat\CheshireCat\DTO\Api\Admins\CreatedOutput;
use DataMat\CheshireCat\DTO\Api\Admins\ResetOutput;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Utils;

class UtilsEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/utils';

    /**
     * This endpoint is used to reset the system to factory settings. This will delete all data in the system.
     *
     * @throws GuzzleException
     */
    public function postFactoryReset(): ResetOutput
    {
        return $this->postJson(
            $this->formatUrl('/factory/reset/'),
            $this->systemId,
            ResetOutput::class,
        );
    }

    /**
     * This endpoint is used to retrieve all the agents in the system.
     *
     * @return string[]
     *
     * @throws GuzzleException
     */
    public function getAgents(): array
    {
        return $this->get(
            $this->formatUrl('/agents/'),
            $this->systemId,
        );
    }

    /**
     * This endpoint is used to create a new agent from scratch.
     *
     * @throws GuzzleException
     */
    public function postAgentCreate(string $agentId): CreatedOutput
    {
        $endpoint = $this->formatUrl('/agents/create/');
        $payload = ['agent_id' => $agentId];

        $response = $this->getHttpClient()->post($endpoint, $payload);
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Failed to create agent');
        }

        return $this->deserialize($response, CreatedOutput::class);
    }

    /**
     * This endpoint is used to reset the agent to factory settings. This will delete all data in the agent.
     *
     * @throws GuzzleException
     */
    public function postAgentReset(string $agentId): ResetOutput
    {
        return $this->postJson(
            $this->formatUrl('/agents/reset/'),
            $agentId,
            ResetOutput::class,
        );
    }

    /**
     * This endpoint is used to reset the agent to factory settings. This will delete all data in the agent.
     *
     * @throws GuzzleException
     */
    public function postAgentDestroy(string $agentId): ResetOutput
    {
        return $this->postJson(
            $this->formatUrl('/agents/destroy/'),
            $agentId,
            ResetOutput::class,
        );
    }

    /**
     * This endpoint is used to clone an existing agent to a new one.
     *
     * @throws GuzzleException
     */
    public function postAgentClone(string $agentId, string $newAgentId): ClonedOutput
    {
        return $this->postJson(
            $this->formatUrl('/agents/clone/'),
            $agentId,
            ClonedOutput::class,
            ['agent_id' => $newAgentId],
        );
    }
}