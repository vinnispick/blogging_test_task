<?php

declare(strict_types=1);

namespace App\Presentation\Web\Action;

use App\Domain\Service\ArticleService;
use App\Presentation\Web\Responder\ResponderInterface;
use App\Core\SecurityUtil;
use RuntimeException;

/**
 * Action for the article details page.
 * Displays article content and similar articles.
 */
class ArticlePageAction implements ActionInterface
{
    public function __construct(
        private readonly ArticleService $articleService,
        private readonly ResponderInterface $responder
    ) {
    }

    /**
     * @param array $request Query parameters
     */
    public function __invoke(array $request): void
    {
        try {
            $articleId = SecurityUtil::sanitizeInt($request['id'] ?? 0);
            if ($articleId <= 0) {
                $this->responder->error(400, "Missing or invalid Article ID.");
                return;
            }

            // 1. Fetch article details
        $article = $this->articleService->getArticleDetails($articleId);
        if ($article === null) {
            throw new RuntimeException("Article not found: {$articleId}");
        }

            // 2. Calculate Reading Time (Refactored logic)
            $wordCount = str_word_count(strip_tags($article->content));
            $readingTime = (int)ceil($wordCount / 200);

            // 3. Fetch similar articles (3 posts from same category)
            $similarArticles = $this->articleService->getSimilarArticles($articleId, 3);

            // 4. Render
            $this->responder->render('pages/article', [
                'article' => $article,
                'readingTime' => $readingTime,
                'similarArticles' => $similarArticles,
                'pageTitle' => $article->title
            ]);

        } catch (RuntimeException $e) {
            $this->responder->error(404, $e->getMessage());
        } catch (\Exception $e) {
            $this->responder->error(500, "An internal error occurred: " . $e->getMessage());
        }
    }
}
