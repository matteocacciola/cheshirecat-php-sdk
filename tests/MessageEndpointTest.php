<?php

namespace DataMat\CheshireCat\Tests;

use DataMat\CheshireCat\DTO\Api\Message\MessageOutput;
use DataMat\CheshireCat\DTO\Message;
use DataMat\CheshireCat\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class MessageEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws \JsonException|GuzzleException|Exception
     */
    public function testSendHttpMessage(): void
    {
        $expected = [
            'text' => 'Hello World',
            'type' => 'chat',
            'why' => [
                'input' => 'input',
                'memory' => [
                    'declarative' => [],
                    'procedural' => [],
                ],
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->message();
        $response = $endpoint->sendHttpMessage(
            new Message($expected['text']), 'agent_id', 'user_id'
        );

        self::assertInstanceOf(MessageOutput::class, $response);

        self::assertEquals($response->text, $expected['text']);
        self::assertEquals($response->content, $expected['text']);
        self::assertEquals($response->type, $expected['type']);
        self::assertEquals($response->why->input, $expected['why']['input']);
        self::assertEquals($response->why->memory->declarative, $expected['why']['memory']['declarative']);
        self::assertEquals($response->why->memory->procedural, $expected['why']['memory']['procedural']);
    }

    /**
     * @throws \JsonException|GuzzleException|Exception
     */
    public function testSendWebsocketMessage(): void
    {
        $expected = [
            'text' => 'Hello World',
            'type' => 'chat',
            'why' => [
                'input' => 'input',
                'memory' => [
                    'declarative' => [],
                    'procedural' => [],
                ],
            ],
        ];

        $cheshireCatClient = $this->getCheshireCatClient($this->apikey, $expected);

        $endpoint = $cheshireCatClient->message();
        $response = $endpoint->sendWebsocketMessage(
            new Message($expected['text']), 'agent_id', 'user_id'
        );

        self::assertInstanceOf(MessageOutput::class, $response);

        self::assertEquals($response->text, $expected['text']);
        self::assertEquals($response->type, $expected['type']);
        self::assertEquals($response->why->input, $expected['why']['input']);
        self::assertEquals($response->why->memory->declarative, $expected['why']['memory']['declarative']);
        self::assertEquals($response->why->memory->procedural, $expected['why']['memory']['procedural']);
    }
}