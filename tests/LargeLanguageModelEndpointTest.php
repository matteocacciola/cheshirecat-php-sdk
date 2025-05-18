<?php

namespace DataMat\CheshireCat\Tests;

use DataMat\CheshireCat\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class LargeLanguageModelEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testGetLargeLanguageModelsSettingsSuccess(): void
    {
        $expected = [
            'settings' => [
                [
                    'name' => 'testLargeLanguageModel',
                    'value' => [
                        'property_first' => 'value_first',
                        'property_second' => 'value_second',
                    ],
                    'scheme' => [
                        'property_first' => 'value_first',
                        'property_second' => 'value_second',
                    ],
                ],
            ],
            'selected_configuration' => 'testLargeLanguageModel',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->largeLanguageModel();
        $result = $endpoint->getLargeLanguageModelsSettings('agent');

        foreach ($expected['settings'] as $key => $setting) {
            self::assertEquals($setting['name'], $result->settings[$key]->name);
            foreach ($setting['value'] as $property => $value) {
                self::assertEquals($value, $result->settings[$key]->value[$property]);
            }
            foreach ($setting['scheme'] as $property => $value) {
                self::assertEquals($value, $result->settings[$key]->scheme[$property]);
            }
        }
        self::assertEquals($expected['selected_configuration'], $result->selectedConfiguration);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testGetLargeLanguageModelSettingsSuccess(): void
    {
        $expected = [
            'name' => 'testLargeLanguageModel',
            'value' => [
                'property_first' => 'value_first',
                'property_second' => 'value_second',
            ],
            'scheme' => [
                'property_first' => 'value_first',
                'property_second' => 'value_second',
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->largeLanguageModel();
        $result = $endpoint->getLargeLanguageModelSettings('testLargeLanguageModel', 'agent');

        self::assertEquals($expected['name'], $result->name);
        foreach ($expected['value'] as $property => $value) {
            self::assertEquals($value, $result->value[$property]);
        }
        foreach ($expected['scheme'] as $property => $value) {
            self::assertEquals($value, $result->scheme[$property]);
        }
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testPutLargeLanguageModelSettingsSuccess(): void
    {
        $expected = [
            'name' => 'testLargeLanguageModel',
            'value' => [
                'property_first' => 'value_first',
                'property_second' => 'value_second',
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->largeLanguageModel();
        $result = $endpoint->putLargeLanguageModelSettings('testLargeLanguageModel', 'agent', $expected['value']);

        self::assertEquals($expected['name'], $result->name);
        foreach ($expected['value'] as $property => $value) {
            self::assertEquals($value, $result->value[$property]);
        }
    }
}