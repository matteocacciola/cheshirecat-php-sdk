<?php

namespace DataMat\CheshireCat\DTO\Api\User;

class UserOutput
{
    public string $id;

    public string $username;

    /** @var array<string, array<string>>  */
    public array $permissions;

    #[SerializedName('created_at')]
    public ?float $createdAt = null;

    #[SerializedName('updated_at')]
    public ?float $updatedAt = null;
}