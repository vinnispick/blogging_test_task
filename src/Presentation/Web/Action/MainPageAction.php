<?php

declare(strict_types=1);

namespace App\Presentation\Web\Action;

use App\Domain\Repository\ArticleRepositoryInterface;
use App\Presentation\Web\Responder\ResponderInterface;

/**
 * Action for the home page.
 * Implements "3 posts per category" logic using optimized SQL.
 */
class MainPageAction implements ActionInterface
{
    public function __construct(
        private readonly ArticleRepositoryInterface $articleRepository,
        private readonly ResponderInterface $responder
    ) {
    }

    /**
     * @param array $request Query/Post parameters (unused for home page)
     */
    public function __invoke(array $request): void
    {
        // 1. Fetch categories and their top 3 articles
        $categoryGroups = $this->articleRepository->findTopByCategory(3);

        // 2. Pass data to the responder for rendering.
        $this->responder->render('pages/main', [
            'categoryGroups' => $categoryGroups,
            'pageTitle' => 'Welcome to Blogger',
            'activePage' => 'home'
        ]);
    }
}
