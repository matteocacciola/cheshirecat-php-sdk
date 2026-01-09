<?php

namespace DataMat\CheshireCat;

use DataMat\CheshireCat\Clients\HttpClient;
use DataMat\CheshireCat\Clients\WSClient;
use DataMat\CheshireCat\Endpoints\AbstractEndpoint;
use Symfony\Component\PropertyInfo\Extractor\ConstructorExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @method \DataMat\CheshireCat\Endpoints\AdminsEndpoint admins()
 * @method \DataMat\CheshireCat\Endpoints\AgenticWorkflowEndpoint agenticWorkflow()
 * @method \DataMat\CheshireCat\Endpoints\AuthEndpoint auth()
 * @method \DataMat\CheshireCat\Endpoints\AuthHandlerEndpoint authHandler()
 * @method \DataMat\CheshireCat\Endpoints\ChunkerEndpoint chunker()
 * @method \DataMat\CheshireCat\Endpoints\ConversationEndpoint conversation()
 * @method \DataMat\CheshireCat\Endpoints\CustomEndpoint custom()
 * @method \DataMat\CheshireCat\Endpoints\EmbedderEndpoint embedder()
 * @method \DataMat\CheshireCat\Endpoints\FileManagerEndpoint fileManager()
 * @method \DataMat\CheshireCat\Endpoints\LargeLanguageModelEndpoint largeLanguageModel()
 * @method \DataMat\CheshireCat\Endpoints\MemoryEndpoint memory()
 * @method \DataMat\CheshireCat\Endpoints\MessageEndpoint message()
 * @method \DataMat\CheshireCat\Endpoints\PluginsEndpoint plugins()
 * @method \DataMat\CheshireCat\Endpoints\RabbitHoleEndpoint rabbitHole()
 * @method \DataMat\CheshireCat\Endpoints\UsersEndpoint users()
 * @method \DataMat\CheshireCat\Endpoints\UtilsEndpoint utils()
 * @method \DataMat\CheshireCat\Endpoints\VectorDatabaseEndpoint vectorDatabase()
 * @method \DataMat\CheshireCat\Endpoints\HealthCheckEndpoint healthCheck()
 */
class CheshireCatClient
{
    private WSClient $wsClient;
    private HttpClient $httpClient;
    private Serializer $serializer;

    public function __construct(WSClient $wsClient, HttpClient $httpClient, ?string $token = null)
    {
        $this->wsClient = $wsClient;
        $this->httpClient = $httpClient;

        if ($token) {
            $this->addToken($token);
        }

        $phpDocExtractor = new PhpDocExtractor();
        $reflectionExtractor = new ReflectionExtractor();
        $typeExtractor = new PropertyInfoExtractor(typeExtractors: [
            new ConstructorExtractor([$phpDocExtractor, $reflectionExtractor]),
            $phpDocExtractor,
            $reflectionExtractor
        ]);

        $objectNormalizer = new ObjectNormalizer(
            null,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            propertyTypeExtractor: $typeExtractor,
        );

        $encoder = new JsonEncoder();

        $this->serializer = new Serializer([$objectNormalizer, new ArrayDenormalizer()], [$encoder]);
    }

    public function addToken(string $token): self
    {
        $this->wsClient->setToken($token);
        $this->httpClient->setToken($token);
        return $this;
    }

    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    public function getWsClient(): WSClient
    {
        return $this->wsClient;
    }

    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    public function __call(string $method, $args): AbstractEndpoint
    {
        return CheshireCatFactory::build(
            __NAMESPACE__ . CheshireCatUtility::classize($method),
            $this
        );
    }
}
