<?php

declare(strict_types=1);

namespace App\Presentation\Web\Action;

use App\Domain\Service\ArticleService;
use App\Presentation\Web\Responder\ResponderInterface;
use App\Core\SecurityUtil;
use RuntimeException;

/**
 * Action for the category page.
 * Handles pagination and sorting.
 */
class CategoryPageAction implements ActionInterface
{
    public function __construct(
        private readonly ArticleService $articleService,
        private readonly ResponderInterface $responder
    ) {
    }

    /**
     * @param array $request Query parameters ($_GET)
     */
    public function __invoke(array $request): void
    {
        try {
            $categoryId = SecurityUtil::sanitizeInt($request['id'] ?? 0);
            if ($categoryId <= 0) {
                $this->responder->error(400, "Missing or invalid Category ID.");
                return;
            }

            // Pagination & Multi-Sorting Parameters
            $page = SecurityUtil::sanitizeInt($request['page'] ?? 1, 1);
            
            // Parse Multi-Sort: e.g., sort=view_count:desc,published_at:desc
            $sortParam = SecurityUtil::sanitizeString($request['sort'] ?? '');
            $allowedColumns = ['published_at', 'view_count', 'title'];
            $sortCriteria = SecurityUtil::sanitizeSort($sortParam, $allowedColumns);
            
            // Limit from Environment
            $limit = (int)($_ENV['DB_PAGINATION_LIMIT'] ?? 10);

            // 1. Fetch paginated results from Domain Service
            $paginationResult = $this->articleService->getPaginatedByCategory(
                $categoryId, 
                $page, 
                $limit, 
                $sortCriteria
            );

            // 2. AJAX Check
            $isAjaxFromRequest = isset($request['ajax']);
            $isAjaxHeader = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower((string)$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
            $isAjax = ($isAjaxFromRequest === true || $isAjaxHeader === true);
            
            $template = ($isAjax === true) ? 'partials/category_articles' : 'pages/category';

            // 3. Render
            $this->responder->render($template, [
                'pagination' => $paginationResult,
                'pageTitle' => "Category: " . $paginationResult->categoryName,
                'currentSort' => $sortParam,
                'sortCriteria' => $sortCriteria,
                'isAjax' => $isAjax
            ]);

        } catch (RuntimeException $e) {
            $this->responder->error(404, $e->getMessage());
        } catch (\Exception $e) {
            $this->responder->error(500, "An internal error occurred: " . $e->getMessage());
        }
    }
}
