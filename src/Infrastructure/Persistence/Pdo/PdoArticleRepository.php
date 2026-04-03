<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Pdo;

use App\Domain\Entity\Article;
use App\Domain\Entity\Category;
use App\Domain\Repository\ArticleRepositoryInterface;
use App\Application\DTO\ArticleByCategory;
use PDO;

/**
 * PDO Implementation of ArticleRepositoryInterface.
 */
class PdoArticleRepository implements ArticleRepositoryInterface
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * @return ArticleByCategory[]
     */
    public function findTopByCategory(int $limit = 3): array
    {
        $stmt = $this->pdo->prepare("
            WITH RankedArticles AS (
                SELECT 
                    a.*, 
                    c.id as cat_id,
                    c.name as cat_name,
                    c.description as cat_description,
                    ROW_NUMBER() OVER (PARTITION BY c.id ORDER BY a.published_at DESC) as rn
                FROM articles a
                JOIN article_category ac ON a.id = ac.article_id
                JOIN categories c ON ac.category_id = c.id
            )
            SELECT * FROM RankedArticles 
            WHERE rn <= :limit 
            ORDER BY cat_name ASC, published_at DESC
        ");
        
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = [];
        $currentCategoryId = -1;
        $currentCategory = null;
        $currentArticles = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $catId = (int)$row['cat_id'];
            
            if ($catId !== $currentCategoryId) {
                if ($currentCategory !== null) {
                    $results[] = new ArticleByCategory($currentCategory, $currentArticles);
                }
                
                $currentCategoryId = $catId;
                $currentCategory = new Category(
                    id: $catId,
                    name: $row['cat_name'],
                    description: $row['cat_description']
                );
                $currentArticles = [];
            }
            
            $currentArticles[] = $this->mapToEntity($row);
        }
        
        if ($currentCategory !== null) {
            $results[] = new ArticleByCategory($currentCategory, $currentArticles);
        }
        
        return $results;
    }

    /**
     * @return Article[]
     */
    public function findLatestByCategory(int $categoryId, int $limit = 3): array
    {
        $stmt = $this->pdo->prepare("
            SELECT a.* FROM articles a
            JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id = :category_id
            ORDER BY a.published_at DESC
            LIMIT :limit
        ");
        
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $articles = [];
        while ($row = $stmt->fetch()) {
            $articles[] = $this->mapToEntity($row);
        }
        
        return $articles;
    }

    /**
     * @param array $sortCriteria Array of ['column' => string, 'direction' => string]
     * @return Article[]
     */
    public function findByCategory(
        int $categoryId, 
        int $offset = 0, 
        int $limit = 10, 
        array $sortCriteria = []
    ): array {
        $allowedSortColumns = ['published_at', 'view_count', 'title'];
        $orderByParts = [];

        foreach ($sortCriteria as $criteria) {
            $column = $criteria['column'] ?? 'published_at';
            $direction = strtoupper($criteria['direction'] ?? 'DESC') === 'ASC' ? 'ASC' : 'DESC';

            if (in_array($column, $allowedSortColumns, true)) {
                $orderByParts[] = "a.{$column} {$direction}";
            }
        }

        $orderByClause = "";
        if (!empty($orderByParts)) {
            $orderByClause = "ORDER BY " . implode(', ', $orderByParts);
        }

        $stmt = $this->pdo->prepare("
            SELECT a.* FROM articles a
            JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id = :category_id
            {$orderByClause}
            LIMIT :limit OFFSET :offset
        ");
        
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $articles = [];
        while ($row = $stmt->fetch()) {
            $articles[] = $this->mapToEntity($row);
        }
        
        return $articles;
    }

    public function getTotalByCategory(int $categoryId): int
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM article_category WHERE category_id = :category_id
        ");
        $stmt->execute(['category_id' => $categoryId]);
        
        return (int)$stmt->fetchColumn();
    }

    public function findById(int $id): ?Article
    {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        $row = $stmt->fetch();
        if ($row === false) {
            return null;
        }

        $categories = $this->getCategoriesByArticleId($id);
        return $this->mapToEntity($row, $categories);
    }

    /**
     * @return Article[]
     */
    public function findSimilar(int $articleId, int $limit = 3): array
    {
        $stmt = $this->pdo->prepare("
            SELECT category_id FROM article_category WHERE article_id = :article_id
        ");
        $stmt->execute(['article_id' => $articleId]);
        $categoryIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($categoryIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT a.* FROM articles a
            JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id IN ($placeholders)
            AND a.id != ?
            ORDER BY a.published_at DESC
            LIMIT ?
        ");

        $params = array_merge($categoryIds, [$articleId, $limit]);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();

        $articles = [];
        while ($row = $stmt->fetch()) {
            $articles[] = $this->mapToEntity($row);
        }

        return $articles;
    }

    /**
     * @return Category[]
     */
    private function getCategoriesByArticleId(int $articleId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT c.* FROM categories c
            JOIN article_category ac ON c.id = ac.category_id
            WHERE ac.article_id = :article_id
        ");
        $stmt->execute(['article_id' => $articleId]);
        
        $categories = [];
        while ($row = $stmt->fetch()) {
            $categories[] = new Category(
                id: (int)$row['id'],
                name: $row['name'],
                description: $row['description'] ?? null
            );
        }
        
        return $categories;
    }

    private function mapToEntity(array $row, ?array $categories = null): Article
    {
        return new Article(
            id: (int)$row['id'],
            title: $row['title'],
            imageUrl: $row['image_url'] ?? null,
            shortDescription: $row['short_description'] ?? "",
            content: $row['content'] ?? "",
            viewCount: (int)$row['view_count'],
            publishedAt: $row['published_at'] ?? null,
            categories: $categories,
            createdAt: $row['created_at'] ?? null,
            updatedAt: $row['updated_at'] ?? null
        );
    }
}
