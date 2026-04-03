<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Article;
use App\Application\DTO\ArticleByCategory;

/**
 * Interface ArticleRepositoryInterface
 */
interface ArticleRepositoryInterface
{
    /**
     * @return ArticleByCategory[]
     */
    public function findTopByCategory(int $limit = 3): array;

    /**
     * @return Article[]
     */
    public function findLatestByCategory(int $categoryId, int $limit = 3): array;

    /**
     * @param array $sortCriteria Array of ['column' => string, 'direction' => string]
     * @return Article[]
     */
    public function findByCategory(
        int $categoryId, 
        int $offset = 0, 
        int $limit = 10, 
        array $sortCriteria = [['column' => 'published_at', 'direction' => 'DESC']]
    ): array;

    public function getTotalByCategory(int $categoryId): int;

    public function findById(int $id): ?Article;

    /**
     * @return Article[]
     */
    public function findSimilar(int $articleId, int $limit = 3): array;
}
