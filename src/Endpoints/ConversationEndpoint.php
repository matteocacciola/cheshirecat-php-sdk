<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Conversation\ConversationDeleteOutput;
use DataMat\CheshireCat\DTO\Api\Conversation\ConversationHistoryOutput;
use DataMat\CheshireCat\DTO\Api\Conversation\ConversationNameChangeOutput;
use DataMat\CheshireCat\DTO\Api\Conversation\ConversationsResponse;
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
     * This endpoint returns all conversation attributes for a given agent and user.
     *
     * @return ConversationsResponse[]
     * @throws \JsonException
     */
    public function getConversations(string $agentId, string $userId): array
    {
        $response = $this->getHttpClient($agentId, $userId)->get($this->prefix,);
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(
                sprintf('Failed to fetch data from endpoint %s: %s', $this->prefix, $response->getReasonPhrase())
            );
        }

        $response = $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
        $result = [];
        foreach ($response as $item) {
            $result[] = $this->deserialize(
                json_encode($item, JSON_THROW_ON_ERROR), ConversationsResponse::class, 'json'
            );
        }
        return $result;
    }

    /**
     * This endpoint deletes the conversation.
     *
     * @throws GuzzleException
     */
    public function deleteConversation(
        string $agentId,
        string $userId,
        string $chatId,
    ): ConversationDeleteOutput {
        return $this->delete(
            $this->formatUrl($chatId),
            $agentId,
            ConversationDeleteOutput::class,
            $userId,
        );
    }

    /**
     * This endpoint changes the name of the conversation.
     *
     * @throws GuzzleException
     */
    public function postConversationName(
        string $name,
        string $agentId,
        string $userId,
        string $chatId,
    ): ConversationHistoryOutput {
        $payload = ['name' => $name];

        return $this->postJson(
            $this->formatUrl($chatId),
            $agentId,
            ConversationNameChangeOutput::class,
            $payload,
            $userId,
        );
    }
}