<?php

namespace DataMat\CheshireCat\Clients;

use Phrity\Net\Uri;
use WebSocket\Client;
use WebSocket\Middleware\CloseHandler;
use WebSocket\Middleware\PingResponder;

class WSClient
{
    protected ?Client $wsClient = null;
    protected string $host;
    protected ?int $port;
    protected ?string $apikey;
    protected ?string $token;
    protected bool $isWSS;

    public function __construct(
        string $host,
        ?int $port = null,
        ?string $apikey = null,
        ?bool $isWSS = null,
    ) {

        $this->host = $host;
        $this->port = $port;
        $this->apikey = $apikey;
        $this->token = null;
        $this->isWSS = $isWSS ?? false;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getClient(string $agentId, string $userId): Client
    {
        if (!$this->apikey && !$this->token) {
            throw new \InvalidArgumentException('You must provide an apikey or a token');
        }

        if (!$this->wsClient) {
            $this->wsClient = $this->createWsClient($agentId, $userId);
        }

        return $this->wsClient;
    }

    public function getWsUri(string $agentId, string $userId): Uri
    {
        $query = [];
        $query['user_id'] = $userId;

        if ($this->token) {
            $query['token'] = $this->token;
        } else {
            $query['apikey'] = $this->apikey;
        }

        return (new Uri())
            ->withScheme($this->isWSS ? 'wss' : 'ws')
            ->withHost($this->host)
            ->withPath(sprintf('ws/%s', $agentId))
            ->withQueryItems($query)
            ->withPort($this->port)
        ;
    }

    protected function createWsClient(string $agentId, string $userId): Client
    {
        $client = new Client($this->getWsUri($agentId, $userId));
        $client->setPersistent(true)
            ->setTimeout(100000)
            // Add CloseHandler middleware
            ->addMiddleware(new CloseHandler())
            // Add PingResponder middleware
            ->addMiddleware(new PingResponder());
        return $client;
    }
}
