<?php

namespace DataMat\CheshireCat\Endpoints;

class HealthCheckEndpoint extends AbstractEndpoint
{
    public function home(): string
    {
        $httpClient = $this->client->getHttpClient()->createHttpClient();

        $response = $httpClient->get('/');
        return $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
    }
}