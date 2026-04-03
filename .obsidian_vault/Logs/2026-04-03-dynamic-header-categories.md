# Log: 2026-04-03 - Dynamic Header Categories

## Technical Decisions Made (ADR Style)
- **Problem**: The site header had hardcoded category links. The requirement was to show the top 5 categories by article count dynamically.
- **Solution**:
    - Extended `CategoryRepositoryInterface` and `PdoCategoryRepository` with `findTopByArticleCount(int $limit)`.
    - Used a SQL JOIN with `article_category` to count articles.
    - Modified `HtmlResponder` to fetch these categories on every request and assign them to the template as `headerCategories`.
    - Although injecting a repository into a responder can be seen as a slight deviation from a "pure" ADR (where the Action usually provides all data), it is a pragmatic solution for global layout data in this custom architecture to avoid bloating every Action.
    - Updated `main.tpl` to iterate over the dynamic collection.

## Modified Files
- `src/Domain/Repository/CategoryRepositoryInterface.php`
- `src/Infrastructure/Persistence/Pdo/PdoCategoryRepository.php`
- `src/Presentation/Web/Responder/HtmlResponder.php`
- `src/Core/Container.php`
- `templates/layouts/main.tpl`
- `Makefile` (added `docker-migrate` for convenience)

## Potential Technical Debt or Future Optimizations
- **Caching**: Currently, the top 5 categories are fetched from the database on every single page load. In a high-traffic scenario, this should be cached (e.g., using Smarty Cache or a PSR-6/PSR-16 cache implementation).
- **View Composers**: If more global data is needed, implementing a "View Composer" pattern would be better than adding more dependencies to the `HtmlResponder`.
