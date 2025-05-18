<?php

namespace DataMat\CheshireCat\Tests;

use DataMat\CheshireCat\Builders\SettingInputBuilder;
use DataMat\CheshireCat\CheshireCatUtility;
use DataMat\CheshireCat\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class SettingsEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetSettingsSuccess(): void
    {
        $expected = [
            'settings' => [
                [
                    'name' => 'testSettingFirst',
                    'value' => [
                        'property_first' => 'value_first',
                        'property_second' => 'value_second',
                    ],
                    'setting_id' => '123456789',
                    'updated_at' => '120323503863468943',
                ],
                [
                    'name' => 'testSettingSecond',
                    'value' => [
                        'property_first' => 'value_first',
                        'property_second' => 'value_second',
                    ],
                    'setting_id' => '234567890',
                    'updated_at' => '120323503863468243',
                ],
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->settings();
        $result = $endpoint->getSettings('agent');

        foreach ($expected['settings'] as $key => $setting) {
            self::assertEquals($setting['name'], $result->settings[$key]->name);
            self::assertEquals($setting['setting_id'], $result->settings[$key]->settingId);
            self::assertEquals($setting['updated_at'], $result->settings[$key]->updatedAt);
            foreach ($setting['value'] as $property => $value) {
                self::assertEquals($value, $result->settings[$key]->value[$property]);
            }
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testPostSettingSuccess(): void
    {
        $expected = [
            'setting' => [
                'name' => 'testSettingFirst',
                'value' => [
                    'property_first' => 'value_first',
                    'property_second' => 'value_second',
                ],
                'category' => 'testCategory',
                'setting_id' => '234567890',
                'updated_at' => '120323503863468243',
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);
        $settingInput = SettingInputBuilder::create()
            ->setName($expected['setting']['name'])
            ->setValue($expected['setting']['value'])
            ->setCategory($expected['setting']['category'])
            ->build();

        $endpoint = $cheshireCatClient->settings();
        $result = $endpoint->postSetting($settingInput, 'agent');

        foreach ($expected['setting'] as $property => $value) {
            $p = CheshireCatUtility::camelCase($property);
            self::assertEquals($value, $result->setting->{$p});
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetSettingSuccess(): void
    {
        $expected = [
            'setting' => [
                'name' => 'testSettingFirst',
                'value' => [
                    'property_first' => 'value_first',
                    'property_second' => 'value_second',
                ],
                'setting_id' => '123456789',
                'updated_at' => '120323503863468943',
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->settings();
        $result = $endpoint->getSetting('123456789', 'agent');

        foreach ($expected['setting'] as $property => $value) {
            $p = CheshireCatUtility::camelCase($property);
            self::assertEquals($value, $result->setting->{$p});
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testPutSettingSuccess(): void
    {
        $expected = [
            'setting' => [
                'name' => 'testSettingFirst',
                'value' => [
                    'property_first' => 'value_first',
                    'property_second' => 'value_second',
                ],
                'category' => 'testCategory',
                'setting_id' => '234567890',
                'updated_at' => '120323503863468243',
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);
        $settingInput = SettingInputBuilder::create()
            ->setName($expected['setting']['name'])
            ->setValue($expected['setting']['value'])
            ->setCategory($expected['setting']['category'])
            ->build();

        $endpoint = $cheshireCatClient->settings();
        $result = $endpoint->putSetting('234567890', 'agent', $settingInput);

        foreach ($expected['setting'] as $property => $value) {
            $p = CheshireCatUtility::camelCase($property);
            self::assertEquals($value, $result->setting->{$p});
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testDeleteSettingSuccess(): void
    {
        $expected = ['deleted' => true];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->settings();
        $result = $endpoint->deleteSetting('234567890', 'agent');

        self::assertTrue($result->deleted);
    }
}