<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Article;
use App\Domain\Repository\ArticleRepositoryInterface;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Application\DTO\PaginationResult;
use RuntimeException;

/**
 * Article Service.
 * Orchestrates business logic for articles.
 */
class ArticleService
{
    public function __construct(
        private readonly ArticleRepositoryInterface $articleRepository,
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * @return Article[]
     */
    public function getLatestByCategory(int $categoryId, int $limit = 3): array
    {
        return $this->articleRepository->findLatestByCategory($categoryId, $limit);
    }

    public function getPaginatedByCategory(
        int $categoryId, 
        int $page = 1, 
        int $limit = 10, 
        array $sortCriteria = []
    ): PaginationResult {
        $category = $this->categoryRepository->findById($categoryId);
        if ($category === null) {
            throw new RuntimeException("Category not found: {$categoryId}");
        }

        $totalItems = $this->articleRepository->getTotalByCategory($categoryId);
        $totalPages = (int)ceil($totalItems / $limit);
        $currentPage = max(1, min($page, $totalPages ?: 1));
        $offset = ($currentPage - 1) * $limit;

        $articles = $this->articleRepository->findByCategory($categoryId, $offset, $limit, $sortCriteria);

        return new PaginationResult(
            articles: $articles,
            categoryId: $categoryId,
            categoryName: $category->name,
            categoryDescription: $category->description,
            totalItems: $totalItems,
            totalPages: $totalPages,
            currentPage: $currentPage,
            limit: $limit
        );
    }

    public function getArticleDetails(int $id): ?Article
    {
        return $this->articleRepository->findById($id);
    }

    /**
     * @return Article[]
     */
    public function getSimilarArticles(int $id, int $limit = 3): array
    {
        return $this->articleRepository->findSimilar($id, $limit);
    }
}
