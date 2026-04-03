<?php

declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * Article Entity.
 * Immutability via readonly properties (PHP 8.1+).
 */
class Article
{
    /**
     * @param Category[]|null $categories
     */
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?string $imageUrl = null,
        public readonly string $shortDescription = "",
        public readonly string $content = "",
        public readonly int $viewCount = 0,
        public readonly ?string $publishedAt = null,
        public readonly ?array $categories = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null
    ) {
    }
}
