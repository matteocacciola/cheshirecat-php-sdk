<?php

namespace DataMat\CheshireCat\Tests;

use DataMat\CheshireCat\Builders\MemoryBuilder;
use DataMat\CheshireCat\Builders\MemoryPointBuilder;
use DataMat\CheshireCat\Builders\WhyBuilder;
use DataMat\CheshireCat\CheshireCatUtility;
use DataMat\CheshireCat\DTO\Api\Memory\MemoryPointsOutput;
use DataMat\CheshireCat\Enum\Collection;
use DataMat\CheshireCat\Enum\Role;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;

class MemoryEndpointTest extends BaseTest
{
    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetMemoryCollectionsSuccess(): void
    {
        $expected = [
            'collections' => [
                ['name' => 'declarative', 'vectors_count' => 100],
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();
        $result = $endpoint->getMemoryCollections('agent');

        foreach ($expected['collections'] as $key => $collection) {
            self::assertEquals($collection['name'], $result->collections[$key]->name);
            self::assertEquals($collection['vectors_count'], $result->collections[$key]->vectorsCount);
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testDeleteMemoryCollectionsSuccess(): void
    {
        $expected = [
            'deleted' => [
                'declarative' => false,
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();
        $result = $endpoint->deleteAllMemoryCollectionPoints('agent');

        foreach ($expected['deleted'] as $key => $value) {
            self::assertEquals($value, $result->deleted[$key]);
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testDeleteMemoryCollectionSuccess(): void
    {
        $expected = [
            'deleted' => [
                'declarative' => true,
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();
        $result = $endpoint->deleteAllSingleMemoryCollectionPoints(Collection::Declarative, 'agent');

        self::assertEquals($expected['deleted']['declarative'], $result->deleted['declarative']);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetConversationHistorySuccess(): void
    {
        $expected = [
            'history' => [
                [
                    'who' => 'user',
                    'when' => 0.0,
                    'content' => [
                        'text' => 'Hey you!',
                    ],
                ],
                [
                    'who' => 'assistant',
                    'when' => 0.1,
                    'content' => [
                        'text' => 'Hi!',
                    ],
                ],
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();
        $result = $endpoint->getConversationHistory('agent', 'user');

        self::assertEquals($expected, $result->toArray());
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testDeleteConversationHistorySuccess(): void
    {
        $expected = ['deleted' => true];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();
        $result = $endpoint->deleteConversationHistory('agent', 'user');

        self::assertEquals($expected['deleted'], $result->deleted);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testPostConversationHistorySuccess(): void
    {
        $expected = [
            'history' => [
                [
                    'who' => 'user',
                    'when' => 0.0,
                    'content' => [
                        'text' => 'Hey you!',
                    ],
                ],
                [
                    'who' => 'assistant',
                    'when' => 0.1,
                    'content' => [
                        'text' => 'Hi!',
                        'why' => [
                            'input' => 'input',
                            'intermediate_steps' => [],
                            'memory' => [
                                'declarative' => [],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $memory = MemoryBuilder::create()
            ->setDeclarative($expected['history'][1]['content']['why']['memory']['declarative'])
            ->build();

        $why = WhyBuilder::create()
            ->setInput($expected['history'][1]['content']['why']['input'])
            ->setIntermediateSteps($expected['history'][1]['content']['why']['intermediate_steps'])
            ->setMemory($memory)
            ->build();

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();
        $result = $endpoint->postConversationHistory(
            Role::ASSISTANT,
            $expected['history'][1]['content']['text'],
            'agent',
            'user',
            null,
            $why,
        );

        self::assertEquals($expected, $result->toArray());
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetMemoryRecallSuccess(): void
    {
        $expected = [
            'query' => ['text' => 'test', 'vector' => []],
            'vectors' => [
                'embedder' => 'testEmbedder',
                'collections' => [
                    'declarative' => [],
                ],
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();
        $result = $endpoint->getMemoryRecall($expected['query']['text'], 'agent', 'user');

        self::assertEquals($expected['vectors']['embedder'], $result->vectors->embedder);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testPostMemoryPointSuccess(): void
    {
        $expected = [
            'content' => 'test',
            'metadata' => [],
            'id' => 'test_test_test',
            'vector' => [],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();

        $memoryPoint = MemoryPointBuilder::create()
            ->setContent($expected['content'])
            ->setMetadata($expected['metadata'])
            ->build();
        $result = $endpoint->postMemoryPoint(Collection::Declarative, 'agent', 'user', $memoryPoint);

        self::assertEquals($expected['id'], $result->id);
        self::assertEquals($expected['vector'], $result->vector);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testPutMemoryPointSuccess(): void
    {
        $expected = [
            'content' => 'test',
            'metadata' => [],
            'id' => 'test_test_test',
            'vector' => [],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();

        $memoryPoint = MemoryPointBuilder::create()
            ->setContent($expected['content'])
            ->setMetadata($expected['metadata'])
            ->build();
        $result = $endpoint->putMemoryPoint(
            Collection::Declarative,
            'agent',
            'user',
            $memoryPoint,
            $expected['id']
        );

        self::assertEquals($expected['id'], $result->id);
        self::assertEquals($expected['vector'], $result->vector);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testDeleteMemoryPointSuccess(): void
    {
        $expected = [
            'deleted' => 'test',
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();
        $result = $endpoint->deleteMemoryPoint(Collection::Declarative, 'agent', $expected['deleted']);

        self::assertEquals($expected['deleted'], $result->deleted);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testDeleteMemoryPointsByMetadataSuccess(): void
    {
        $metadata = [
            'property1' => 'value1',
            'property2' => 'value2',
            'property3' => 'value3',
            'property4' => 'value4',
            'property5' => 'value5',
        ];

        $expected = [
            'deleted' => ['operation_id' => 21212414, 'status' => 'ok'],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();
        $result = $endpoint->deleteMemoryPointsByMetadata(Collection::Declarative, 'agent', $metadata);

        foreach ($expected['deleted'] as $key => $value) {
            self::assertEquals($value, $result->deleted->{CheshireCatUtility::camelCase($key)});
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetMemoryPointsSuccess(): void
    {
        $expected = [
            'points' => [
                ['id' => 'dgwrgsehsreysery'],
                ['id' => 'weuhg42jdgouwrow4ls'],
            ],
            'next_offset' => 0,
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->memory();
        $result = $endpoint->getMemoryPoints(Collection::Declarative, 'agent');

        self::assertInstanceOf(MemoryPointsOutput::class, $result);
    }
}