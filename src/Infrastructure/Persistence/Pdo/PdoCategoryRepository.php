<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Pdo;

use App\Domain\Entity\Category;
use App\Domain\Repository\CategoryRepositoryInterface;
use PDO;

/**
 * PDO Implementation of CategoryRepositoryInterface.
 */
class PdoCategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * @return Category[]
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY name ASC");
        
        $categories = [];
        while ($row = $stmt->fetch()) {
            $categories[] = $this->mapToEntity($row);
        }
        
        return $categories;
    }

    public function findById(int $id): ?Category
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        $row = $stmt->fetch();
        if ($row === false) {
            return null;
        }

        return $this->mapToEntity($row);
    }

    public function findTopByArticleCount(int $limit): array
    {
        $stmt = $this->pdo->prepare("
            SELECT c.*, COUNT(ac.article_id) as article_count
            FROM categories c
            JOIN article_category ac ON c.id = ac.category_id
            GROUP BY c.id
            ORDER BY article_count DESC, c.name ASC
            LIMIT :limit
        ");
        
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $categories = [];
        while ($row = $stmt->fetch()) {
            $categories[] = $this->mapToEntity($row);
        }
        
        return $categories;
    }

    private function mapToEntity(array $row): Category
    {
        return new Category(
            id: (int)$row['id'],
            name: $row['name'],
            description: $row['description'] ?? null,
            createdAt: $row['created_at'] ?? null,
            updatedAt: $row['updated_at'] ?? null
        );
    }
}
