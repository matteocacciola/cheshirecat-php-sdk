<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Setting\SettingDeleteOutput;
use DataMat\CheshireCat\DTO\Api\Setting\SettingOutputItem;
use DataMat\CheshireCat\DTO\Api\Setting\SettingsOutputCollection;
use DataMat\CheshireCat\DTO\SettingInput;
use GuzzleHttp\Exception\GuzzleException;

class SettingsEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/settings';

    /**
     * This endpoint returns the settings of the agent identified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function getSettings(string $agentId): SettingsOutputCollection
    {
        return $this->get($this->prefix, $agentId, SettingsOutputCollection::class);
    }

    /**
     * This method creates a new setting for the agent identified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function postSetting(SettingInput $values, string $agentId): SettingOutputItem
    {
        return $this->postJson(
            $this->prefix,
            $agentId,
            SettingOutputItem::class,
            $values->toArray(),
        );
    }

    /**
     * This endpoint returns the setting identified by the settingId parameter. The setting must belong to the agent
     * identified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function getSetting(string $settingId, string $agentId): SettingOutputItem
    {
        return $this->get(
            $this->formatUrl($settingId),
            $agentId,
            SettingOutputItem::class,
        );
    }

    /**
     * This method updates the setting identified by the settingId parameter. The setting must belong to the agent
     * identified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function putSetting(string $settingId, string $agentId, SettingInput $values): SettingOutputItem
    {
        return $this->put(
            $this->formatUrl($settingId),
            $agentId,
            SettingOutputItem::class,
            $values->toArray(),
        );
    }

    /**
     * This endpoint deletes the setting identified by the settingId parameter. The setting must belong to the agent
     * identified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function deleteSetting(string $settingId, string $agentId): SettingDeleteOutput
    {
        return $this->delete(
            $this->formatUrl($settingId),
            $agentId,
            SettingDeleteOutput::class,
        );
    }
}