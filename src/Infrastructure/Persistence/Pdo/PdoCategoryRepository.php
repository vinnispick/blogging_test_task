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
