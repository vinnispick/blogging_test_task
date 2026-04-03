<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Category;

/**
 * Interface CategoryRepositoryInterface
 */
interface CategoryRepositoryInterface
{
    /**
     * @return Category[]
     */
    public function findAll(): array;

    public function findById(int $id): ?Category;

    /**
     * @return Category[]
     */
    public function findTopByArticleCount(int $limit): array;
}
