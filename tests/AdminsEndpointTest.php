<?php

namespace DataMat\CheshireCat\Tests;

use DataMat\CheshireCat\DTO\Api\Plugin\PluginsSettingsOutput;
use DataMat\CheshireCat\DTO\Api\Plugin\Settings\PluginSettingsOutput;
use DataMat\CheshireCat\Tests\Traits\TestTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class AdminsEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws Exception|\JsonException|GuzzleException
     */
    public function testTokenSuccess(): void
    {
        $expected = [
            'access_token' => 'token',
            'token_type' => 'bearer',
        ];

        $cheshireCatClient = $this->getCheshireCatClient(null, $expected);
        try {
            $cheshireCatClient->getHttpClient()->getClient();
        } catch (\Exception $e) {
            self::assertInstanceOf(\InvalidArgumentException::class, $e);
            self::assertEquals('You must provide an apikey or a token', $e->getMessage());
        }

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->token('test-user', 'test-pass');

        self::assertEquals($expected['access_token'], $result->accessToken);
        self::assertEquals($expected['token_type'], $result->tokenType);

        $httpClient = $cheshireCatClient->getHttpClient()->getClient();

        self::assertInstanceOf(Client::class, $httpClient);
    }

    /**
     * @throws \JsonException|GuzzleException|Exception
     */
    public function testPostAdminSuccess(): void
    {
        $expected = [
            'username' => 'username',
            'password' => 'password',
            'permissions' => [
                'permission' => ['permission'],
            ],
            'id' => 'id',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->postAdmin($expected['username'], $expected['password'], $expected['permissions']);

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testGetAdminsSuccess(): void
    {
        $expected = [
            [
                'username' => 'username',
                'permissions' => [
                    'permission' => ['permission'],
                ],
                'id' => 'id',
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->getAdmins();

        self::assertCount(1, $result);
        self::assertEquals($expected[0]['username'], $result[0]->username);
        self::assertEquals($expected[0]['permissions'], $result[0]->permissions);
        self::assertEquals($expected[0]['id'], $result[0]->id);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testGetAdminSuccess(): void
    {
        $expected = [
            'username' => 'username',
            'permissions' => [
                'permission' => ['permission'],
            ],
            'id' => 'id',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->getAdmin($expected['id']);

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testPutAdminSuccess(): void
    {
        $expected = [
            'username' => 'username',
            'password' => 'password',
            'permissions' => [
                'permission' => ['permission'],
            ],
            'id' => 'id',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->putAdmin(
            $expected['id'], $expected['username'], $expected['password'], $expected['permissions']
        );

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testDeleteAdminSuccess(): void
    {
        $expected = [
            'username' => 'username',
            'permissions' => [
                'permission' => ['permission'],
            ],
            'id' => 'id',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->deleteAdmin($expected['id']);

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testFactoryResetSuccess(): void
    {
        $expected = [
            'deleted_settings' => true,
            'deleted_memories' => true,
            'deleted_plugin_folders' => true,
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->postFactoryReset();

        self::assertTrue($result->deletedSettings);
        self::assertTrue($result->deletedMemories);
        self::assertTrue($result->deletedPluginFolders);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testAgentResetSuccess(): void
    {
        $expected = [
            'deleted_settings' => true,
            'deleted_memories' => true,
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->postAgentReset('agent');

        self::assertTrue($result->deletedSettings);
        self::assertTrue($result->deletedMemories);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testAgentDestroySuccess(): void
    {
        $expected = [
            'deleted_settings' => true,
            'deleted_memories' => true,
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->postAgentDestroy('agent');

        self::assertTrue($result->deletedSettings);
        self::assertTrue($result->deletedMemories);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testAgentCreateSuccess(): void
    {
        $expected = [
            'created' => true,
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->postAgentCreate('agent');

        self::assertTrue($result->created);
    }

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

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->getAvailablePlugins();

        self::assertEquals($expected, $result->toArray());
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testInstallPluginFromZipSuccess(): void
    {
        $expected = [
            'filename' => 'tests/Resources/test.txt.zip',
            'content_type' => 'application/zip',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->postInstallPluginFromZip($expected['filename']);

        self::assertEquals($expected['filename'], $result->filename);
        self::assertEquals($expected['content_type'], $result->contentType);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testInstallPluginFromRegistrySuccess(): void
    {
        $url = 'https://plugin1.com';
        $expected = [
            'url' => $url,
            'info' => 'Plugin is being installed asynchronously',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->postInstallPluginFromRegistry($url);

        self::assertEquals($expected['url'], $result->url);
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

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->getPluginsSettings();

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

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->getPluginSettings($expected['name']);

        self::assertInstanceOf(PluginSettingsOutput::class, $result);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetPluginDetailsSuccess(): void
    {
        $expected = [
            'data' => [
                'id' => 'core_plugin',
                'title' => 'Setting 1',
                'active' => true,
                'hooks' => [
                    ['name' => 'hook1', 'priority' => 1],
                    ['name' => 'hook2', 'priority' => 0],
                ],
                'tools' => [
                    ['name' => 'tool1', 'priority' => 1],
                    ['name' => 'tool2', 'priority' => 0],
                ],
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->getPluginDetails('setting1');

        self::assertEquals($expected['data'], $result->data);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testDeletePluginSuccess(): void
    {
        $expected = [
            'deleted' => 'setting_1',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->admins();
        $result = $endpoint->deletePlugin('setting1');

        self::assertEquals($expected['deleted'], $result->deleted);
    }
}