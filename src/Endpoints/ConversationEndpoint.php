<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Conversation\ConversationHistoryDeleteOutput;
use DataMat\CheshireCat\DTO\Api\Conversation\ConversationHistoryOutput;
use DataMat\CheshireCat\DTO\Why;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class ConversationEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/conversation';

    /**
     * This endpoint returns the conversation history.
     *
     * @throws GuzzleException|\JsonException|RuntimeException
     */
    public function getConversationHistory(string $agentId, string $userId, string $chatId): ConversationHistoryOutput
    {
        return $this->get(
            $this->formatUrl($chatId),
            $agentId,
            ConversationHistoryOutput::class,
            $userId,
        );
    }

    /**
     * This endpoint returns all conversation histories for the specified agent.
     *
     * @return array<string, ConversationHistoryOutput>
     * @throws \JsonException
     */
    public function getConversationHistories(string $agentId, string $userId): array
    {
        $response = $this->getHttpClient($agentId, $userId)->get($this->prefix,);
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(
                sprintf('Failed to fetch data from endpoint %s: %s', $this->prefix, $response->getReasonPhrase())
            );
        }

        $response = $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
        return array_map(function ($item) {
            return $this->deserialize(
                json_encode($item, JSON_THROW_ON_ERROR), ConversationHistoryOutput::class, 'json'
            );
        }, $response);
    }

    /**
     * This endpoint deletes the conversation history for the agent identified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function deleteConversationHistory(
        string $agentId,
        string $userId,
        string $chatId,
    ): ConversationHistoryDeleteOutput {
        return $this->delete(
            $this->formatUrl($chatId),
            $agentId,
            ConversationHistoryDeleteOutput::class,
            $userId,
        );
    }

    /**
     * This endpoint creates a new element in the conversation history.
     *
     * @throws GuzzleException
     */
    public function postConversationHistory(
        string $who,
        string $text,
        string $agentId,
        string $userId,
        string $chatId,
        ?string $image = null,
        ?Why $why = null,
    ): ConversationHistoryOutput {
        $payload = [
            'who' => $who,
            'text' => $text,
        ];
        if ($image) {
            $payload['image'] = $image;
        }
        if ($why) {
            $payload['why'] = $why->toArray();
        }

        return $this->postJson(
            $this->formatUrl($chatId),
            $agentId,
            ConversationHistoryOutput::class,
            $payload,
            $userId,
        );
    }
}