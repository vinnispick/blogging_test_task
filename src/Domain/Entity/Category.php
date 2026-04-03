<?php

declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * Category Entity.
 * Immutability via readonly properties (PHP 8.1+).
 */
class Category
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null
    ) {
    }
}
