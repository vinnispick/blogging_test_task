<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Entity\Article;

/**
 * DTO for paginated article lists.
 */
class PaginationResult
{
    /**
     * @param Article[] $articles
     */
    public function __construct(
        public readonly array $articles,
        public readonly int $categoryId,
        public readonly string $categoryName,
        public readonly ?string $categoryDescription,
        public readonly int $totalItems,
        public readonly int $totalPages,
        public readonly int $currentPage,
        public readonly int $limit
    ) {
    }
}
