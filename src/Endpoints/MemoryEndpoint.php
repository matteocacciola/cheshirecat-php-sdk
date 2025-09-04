<?php

namespace DataMat\CheshireCat\Endpoints;

use DataMat\CheshireCat\DTO\Api\Memory\CollectionPointsDestroyOutput;
use DataMat\CheshireCat\DTO\Api\Memory\CollectionsOutput;
use DataMat\CheshireCat\DTO\Api\Memory\ConversationHistoryDeleteOutput;
use DataMat\CheshireCat\DTO\Api\Memory\ConversationHistoryOutput;
use DataMat\CheshireCat\DTO\Api\Memory\MemoryPointDeleteOutput;
use DataMat\CheshireCat\DTO\Api\Memory\MemoryPointOutput;
use DataMat\CheshireCat\DTO\Api\Memory\MemoryPointsDeleteByMetadataOutput;
use DataMat\CheshireCat\DTO\Api\Memory\MemoryPointsOutput;
use DataMat\CheshireCat\DTO\Api\Memory\MemoryRecallOutput;
use DataMat\CheshireCat\DTO\Api\Memory\Nested\CollectionsItem;
use DataMat\CheshireCat\DTO\MemoryPoint;
use DataMat\CheshireCat\DTO\Why;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class MemoryEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/memory';

    // -- Memory Collections API

    /**
     * This endpoint returns the collections of memory points.
     *
     * @throws GuzzleException
     */
    public function getMemoryCollections(string $agentId): CollectionsOutput
    {
        return $this->get(
            $this->formatUrl('/collections'),
            $agentId,
            CollectionsOutput::class,
        );
    }

    /**
     * This endpoint deletes all the points in all the collections of memory.
     *
     * @throws GuzzleException
     */
    public function deleteAllMemoryCollectionPoints(string $agentId): CollectionPointsDestroyOutput
    {
        return $this->delete(
            $this->formatUrl('/collections'),
            $agentId,
            CollectionPointsDestroyOutput::class,
        );
    }

    /**
     * This method deletes all the points in a single collection of memory.
     *
     * @throws GuzzleException
     */
    public function deleteAllSingleMemoryCollectionPoints(
        string $collection,
        string $agentId,
    ): CollectionPointsDestroyOutput {
        return $this->delete(
            $this->formatUrl('/collections/' . $collection),
            $agentId,
            CollectionPointsDestroyOutput::class,
        );
    }

    /**
     * This endpoint creates and returns a collection of memory points.
     *
     * @throws GuzzleException
     */
    public function postMemoryCollections(string $collection, string $agentId): CollectionsItem
    {
        return $this->postJson(
            $this->formatUrl('/collections/' . $collection),
            $agentId,
            CollectionsItem::class,
        );
    }

    // END Memory Collections API --

    // -- Memory Conversation History API

    /**
     * This endpoint returns the conversation history.
     *
     * @throws GuzzleException|\JsonException|RuntimeException
     */
    public function getConversationHistory(string $agentId, string $userId): ConversationHistoryOutput
    {
        return $this->get(
            $this->formatUrl('/conversation_history'),
            $agentId,
            ConversationHistoryOutput::class,
            $userId,
        );
    }

    /**
     * This endpoint deletes the conversation history for the agent identified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function deleteConversationHistory(
        string $agentId,
        string $userId,
    ): ConversationHistoryDeleteOutput {
        return $this->delete(
            $this->formatUrl('/conversation_history'),
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
            $this->formatUrl('/conversation_history'),
            $agentId,
            ConversationHistoryOutput::class,
            $payload,
            $userId,
        );
    }

    // END Memory Conversation History API --

    // -- Memory Points API
    /**
     * This endpoint retrieves memory points based on the input text. The text parameter is the input text for which the
     * memory points are retrieved. The k parameter is the number of memory points to retrieve.
     *
     * @param array<string, mixed>|null $metadata
     *
     * @throws GuzzleException|\JsonException
     */
    public function getMemoryRecall(
        string $text,
        string $agentId,
        string $userId,
        ?int $k = null,
        ?array $metadata = null,
    ): MemoryRecallOutput {
        $query = ['text' => $text];
        if ($k) {
            $query['k'] = $k;
        }
        if ($metadata) {
            $query['metadata'] = json_encode($metadata, JSON_THROW_ON_ERROR);
        }

        return $this->get(
            $this->formatUrl('/recall'),
            $agentId,
            MemoryRecallOutput::class,
            $userId,
            $query,
        );
    }

    /**
     * This method posts a memory point, for the agent identified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function postMemoryPoint(
        string $collection,
        string $agentId,
        string $userId,
        MemoryPoint $memoryPoint,
    ): MemoryPointOutput {
        if ($userId && empty($memoryPoint->metadata['source'])) {
            $memoryPoint->metadata = !empty($memoryPoint->metadata)
                ? $memoryPoint->metadata + ['source' => $userId]
                : ['source' => $userId];
        }

        return $this->postJson(
            $this->formatUrl('/collections/' . $collection . '/points'),
            $agentId,
            MemoryPointOutput::class,
            $memoryPoint->toArray(),
        );
    }

    /**
     * This method puts a memory point, for the agent identified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function putMemoryPoint(
        string $collection,
        string $agentId,
        string $userId,
        MemoryPoint $memoryPoint,
        string $pointId,
    ): MemoryPointOutput {
        if ($userId && empty($memoryPoint->metadata['source'])) {
            $memoryPoint->metadata = !empty($memoryPoint->metadata)
                ? $memoryPoint->metadata + ['source' => $userId]
                : ['source' => $userId];
        }

        return $this->put(
            $this->formatUrl('/collections/' . $collection . '/points' . $pointId),
            $agentId,
            MemoryPointOutput::class,
            $memoryPoint->toArray(),
        );
    }

    /**
     * This endpoint deletes a memory point, for the agent identified by the agentId parameter.
     *
     * @throws GuzzleException
     */
    public function deleteMemoryPoint(
        string $collection,
        string $agentId,
        string $pointId,
    ): MemoryPointDeleteOutput {
        return $this->delete(
            $this->formatUrl('/collections/' . $collection . '/points/'. $pointId),
            $agentId,
            MemoryPointDeleteOutput::class,
        );
    }

    /**
     * This endpoint deletes memory points based on the metadata, for the agent identified by the agentId
     * parameter. The metadata parameter is a dictionary of key-value pairs that the memory points must match.
     *
     * @param array<string, mixed>|null $metadata
     *
     * @throws GuzzleException
     */
    public function deleteMemoryPointsByMetadata(
        string $collection,
        string $agentId,
        ?array $metadata = null,
    ): MemoryPointsDeleteByMetadataOutput {
        return $this->delete(
            $this->formatUrl('/collections/' . $collection . '/points'),
            $agentId,
            MemoryPointsDeleteByMetadataOutput::class,
            null,
            $metadata ?? null,
        );
    }

    /**
     * This endpoint retrieves memory points. The limit parameter is the maximum number of memory points to retrieve.
     * The offset parameter is the number of memory points to skip.
     *
     * @param array<string, mixed>|null $metadata
     *
     * @throws GuzzleException
     */
    public function getMemoryPoints(
        string $collection,
        string $agentId,
        ?int $limit = null,
        ?int $offset = null,
        ?array $metadata = null,
    ): MemoryPointsOutput {
        $query = [];
        if ($limit !== null) {
            $query['limit'] = $limit;
        }
        if ($offset !== null) {
            $query['offset'] = $offset;
        }
        if ($metadata) {
            $query['metadata'] = json_encode($metadata, JSON_THROW_ON_ERROR);
        }

        return $this->get(
            $this->formatUrl('/collections/' . $collection . '/points'),
            $agentId,
            MemoryPointsOutput::class,
            null,
            $query ?: null,
        );
    }

    // END Memory Points API --
}