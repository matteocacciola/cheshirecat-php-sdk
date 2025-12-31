<?php

namespace DataMat\CheshireCat\DTO\Api;

use Symfony\Component\Serializer\Annotation\SerializedName;

class UserMeOutput
{
    public string $id;

    public string $username;

    /** @var array<string, string[]> */
    public array $permissions;

    #[SerializedName('created_at')]
    public ?float $createdAt = null;

    #[SerializedName('updated_at')]
    public ?float $updatedAt = null;
}