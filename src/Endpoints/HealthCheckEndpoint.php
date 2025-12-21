<?php

namespace DataMat\CheshireCat\Endpoints;

class HealthCheckEndpoint extends AbstractEndpoint
{
    public function liveness(): string
    {
        $httpClient = $this->client->getHttpClient()->createHttpClient();

        $response = $httpClient->get('/health/liveness');
        return $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
    }

    public function readiness(): string
    {
        $httpClient = $this->client->getHttpClient()->createHttpClient();

        $response = $httpClient->get('/health/readiness');
        return $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
    }
}