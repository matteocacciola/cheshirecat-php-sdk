<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingOutput;
use DataMat\CheshireCat\DTO\Api\Factory\FactoryObjectSettingsOutput;
use DataMat\CheshireCat\DTO\SettingInput;
use GuzzleHttp\Exception\GuzzleException;

class AuthHandlerEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/auth_handler';

    /**
     * This endpoint returns the settings of all the authentication handlers. It is used to get the settings of all the
     * authentication handlers that are available in the agent specified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function getAuthHandlersSettings(string $agentId): FactoryObjectSettingsOutput
    {
        return $this->get(
            $this->formatUrl('/settings'),
            $agentId,
            FactoryObjectSettingsOutput::class,
        );
    }

    /**
     * This endpoint returns the settings of a specific authentication handler. It is used to get the settings of a
     * specific authentication handler that is available in the agent specified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function getAuthHandlerSettings(string $authHandler, string $agentId): FactoryObjectSettingOutput
    {
        return $this->get(
            $this->formatUrl('/settings/' . $authHandler),
            $agentId,
            FactoryObjectSettingOutput::class,
        );
    }

    /**
     * This endpoint updates the settings of a specific authentication handler. It is used to update the settings of a
     * specific authentication handler that is available in the agent specified by the agentId parameter.
     *
     * @param array<string, mixed> $values
     *
     * @throws GuzzleException
     */
    public function putAuthHandlerSettings(
        string $authHandler,
        string $agentId,
        array $values,
    ): FactoryObjectSettingOutput {
        return $this->put(
            $this->formatUrl('/settings/' . $authHandler),
            $agentId,
            FactoryObjectSettingOutput::class,
            $values,
        );
    }
}