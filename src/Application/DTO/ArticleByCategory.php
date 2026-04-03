<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Entity\Article;
use App\Domain\Entity\Category;

/**
 * DTO for grouped articles on the main page.
 */
class ArticleByCategory
{
    /**
     * @param Article[] $articles
     */
    public function __construct(
        public readonly Category $category,
        public readonly array $articles
    ) {
    }
}
