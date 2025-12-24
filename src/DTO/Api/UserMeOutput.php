<?php

namespace DataMat\CheshireCat\DTO\Api;

use Symfony\Component\Serializer\Annotation\SerializedName;

class UserMeOutput
{
    public string $id;

    public string $username;

    /** @var array<string, string[]> */
    public array $permissions;
}