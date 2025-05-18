<?php

namespace DataMat\CheshireCat\Tests;

use DataMat\CheshireCat\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class FileManagerEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testGetFileManagersSettingsSuccess(): void
    {
        $expected = [
            'settings' => [
                [
                    'name' => 'testFileManager',
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
            'selected_configuration' => 'testFileManager',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->fileManager();
        $result = $endpoint->getFileManagersSettings('agent');

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
    public function testGetFileManagerSettingsSuccess(): void
    {
        $expected = [
            'name' => 'testFileManager',
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

        $endpoint = $cheshireCatClient->fileManager();
        $result = $endpoint->getFileManagerSettings('testFileManager', 'agent');

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
    public function testPutFileManagerSettingsSuccess(): void
    {
        $expected = [
            'name' => 'testFileManager',
            'value' => [
                'property_first' => 'value_first',
                'property_second' => 'value_second',
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->fileManager();
        $result = $endpoint->putFileManagerSettings('testFileManager', 'agent', $expected['value']);

        self::assertEquals($expected['name'], $result->name);
        foreach ($expected['value'] as $property => $value) {
            self::assertEquals($value, $result->value[$property]);
        }
    }
}