<?php

namespace DataMat\CheshireCat\DTO\Api;

use Symfony\Component\Serializer\Annotation\SerializedName;

class TokenOutput
{
    #[SerializedName('access_token')]
    public string $accessToken;

    #[SerializedName('token_type')]
    public string $tokenType = 'bearer';
}