<?php

namespace DataMat\CheshireCat\DTO\Api;

class TokenOutput
{
    public string $accessToken;
    public string $tokenType = 'bearer';
}