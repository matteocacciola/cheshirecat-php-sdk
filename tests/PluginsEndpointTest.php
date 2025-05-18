<?php

namespace DataMat\CheshireCat\Tests;

use DataMat\CheshireCat\DTO\Api\Plugin\PluginsSettingsOutput;
use DataMat\CheshireCat\DTO\Api\Plugin\Settings\PluginSettingsOutput;
use DataMat\CheshireCat\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class PluginsEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetAvailablePluginsSuccess(): void
    {
        $expected = [
            'filters' => [
                'query' => null,
            ],
            'installed' => [
                [
                    'id' => '1',
                    'name' => 'Plugin 1',
                    'description' => 'Description 1',
                    'author_name' => 'Author 1',
                    'author_url' => 'https://author1.com',
                    'plugin_url' => 'https://plugin1.com',
                    'tags' => 'tag1, tag2',
                    'thumb' => 'https://thumb1.com',
                    'version' => '1.0.0',
                    'active' => true,
                    'hooks' => [],
                    'tools' => [],
                    'forms' => [],
                    'endpoints' => [],
                ],
                [
                    'id' => '2',
                    'name' => 'Plugin 2',
                    'description' => 'Description 2',
                    'author_name' => 'Author 2',
                    'author_url' => 'https://author2.com',
                    'plugin_url' => 'https://plugin2.com',
                    'tags' => 'tag1, tag2',
                    'thumb' => 'https://thumb2.com',
                    'version' => '1.0.0',
                    'active' => true,
                    'hooks' => [],
                    'tools' => [],
                    'forms' => [],
                    'endpoints' => [],
                ]
            ],
            'registry' => [
                [
                    'id' => '1',
                    'name' => 'Plugin 1',
                    'description' => 'Description 1',
                    'author_name' => 'Author 1',
                    'author_url' => 'https://author1.com',
                    'plugin_url' => 'https://plugin1.com',
                    'tags' => 'tag1, tag2',
                    'thumb' => 'https://thumb1.com',
                    'version' => '1.0.0',
                    'url' => 'https://plugin1.com',
                ],
                [
                    'id' => '2',
                    'name' => 'Plugin 2',
                    'description' => 'Description 2',
                    'author_name' => 'Author 2',
                    'author_url' => 'https://author2.com',
                    'plugin_url' => 'https://plugin2.com',
                    'tags' => 'tag1, tag2',
                    'thumb' => 'https://thumb2.com',
                    'version' => '1.0.0',
                    'url' => 'https://plugin2.com',
                ]
            ]
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->plugins();
        $result = $endpoint->getAvailablePlugins('agent');

        self::assertEquals($expected, $result->toArray());
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetFilteredAvailablePluginsSuccess(): void
    {
        $expected = [
            'filters' => [
                'query' => 'Plugin 1',
            ],
            'installed' => [
                [
                    'id' => '1',
                    'name' => 'Plugin 1',
                    'description' => 'Description 1',
                    'author_name' => 'Author 1',
                    'author_url' => 'https://author1.com',
                    'plugin_url' => 'https://plugin1.com',
                    'tags' => 'tag1, tag2',
                    'thumb' => 'https://thumb1.com',
                    'version' => '1.0.0',
                    'active' => true,
                    'hooks' => [],
                    'tools' => [],
                    'forms' => [],
                    'endpoints' => [],
                ],
            ],
            'registry' => [
                [
                    'id' => '1',
                    'name' => 'Plugin 1',
                    'description' => 'Description 1',
                    'author_name' => 'Author 1',
                    'author_url' => 'https://author1.com',
                    'plugin_url' => 'https://plugin1.com',
                    'tags' => 'tag1, tag2',
                    'thumb' => 'https://thumb1.com',
                    'version' => '1.0.0',
                    'url' => 'https://plugin1.com',
                ],
            ]
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->plugins();
        $result = $endpoint->getAvailablePlugins('agent', 'Plugin 1');

        self::assertEquals($expected, $result->toArray());
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testTogglePluginSuccess(): void
    {
        $pluginId = 'plugin_1';
        $expected = [
            'info' => 'Plugin plugin_1 toggled',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->plugins();
        $result = $endpoint->putTogglePlugin($pluginId, 'agent');

        self::assertEquals($expected['info'], $result->info);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetPluginsSettingsSuccess(): void
    {
        $expected = [
            'settings' => [
                [
                    'name' => 'setting1',
                    'value' => [
                        'type' => 'string',
                        'value' => 'value1',
                    ],
                    'scheme' => [
                        'title' => 'Setting 1',
                        'type' => 'hook',
                        'properties' => [
                            'property1' => [
                                'title' => 'Property 1',
                                'type' => 'string',
                                'default' => 'default1',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'setting2',
                    'value' => [
                        'type' => 'string',
                        'value' => 'value2',
                    ],
                    'scheme' => [
                        'title' => 'Setting 2',
                        'type' => 'form',
                        'properties' => [
                            'property1' => [
                                'title' => 'Property 2',
                                'type' => 'string',
                                'default' => 'default2',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->plugins();
        $result = $endpoint->getPluginsSettings('agent');

        self::assertInstanceOf(PluginsSettingsOutput::class, $result);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetPluginSettingsSuccess(): void
    {
        $expected = [
            'name' => 'setting1',
            'value' => [
                'type' => 'string',
                'value' => 'value1',
            ],
            'scheme' => [
                'title' => 'Setting 1',
                'type' => 'hook',
                'properties' => [
                    'property1' => [
                        'title' => 'Property 1',
                        'type' => 'string',
                        'default' => 'default1',
                    ],
                ],
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->plugins();
        $result = $endpoint->getPluginSettings($expected['name'], 'agent');

        self::assertInstanceOf(PluginSettingsOutput::class, $result);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testPutPluginSettingsSuccess(): void
    {
        $expected = [
            'name' => 'setting1',
            'value' => [
                'type' => 'string',
                'value' => 'value1',
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->plugins();
        $result = $endpoint->putPluginSettings(
            $expected['name'],
            'agent',
            ['setting_a' => 'some value', 'setting_b' => 'another value'],
        );

        self::assertInstanceOf(PluginSettingsOutput::class, $result);
    }
}