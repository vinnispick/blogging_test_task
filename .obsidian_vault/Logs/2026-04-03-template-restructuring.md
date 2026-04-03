# Log: 2026-04-03-template-restructuring

## Technical Decisions Made (ADR Style)
- **Decision**: Restructure the `templates/` directory into subdirectories (`layouts`, `pages`, `partials`, `components`).
- **Rationale**: The previous flat structure was becoming cluttered and difficult to maintain as the project grew. Segregating files by their role (layout vs. page vs. fragment) improves discoverability and organization.
- **Outcome**: All templates are now logically grouped. PHP actions and template tags have been updated to reflect the new hierarchy.

## Modified Files
- `templates/layouts/main.tpl` (moved from `layout.tpl`)
- `templates/pages/main.tpl` (moved from `main_page.tpl`)
- `templates/pages/category.tpl` (moved from `category_page.tpl`)
- `templates/pages/article.tpl` (moved from `article_page.tpl`)
- `templates/pages/error.tpl` (moved from `error.tpl`)
- `templates/partials/category_articles.tpl` (moved from `category_articles_partial.tpl`)
- `templates/components/article_card.tpl` (moved from `_article_card.tpl`)
- `templates/components/similar_article_mini.tpl` (moved from `_similar_article_mini.tpl`)
- `src/Presentation/Web/Action/MainPageAction.php`
- `src/Presentation/Web/Action/ArticlePageAction.php`
- `src/Presentation/Web/Action/CategoryPageAction.php`
- `src/Presentation/Web/Responder/HtmlResponder.php`

## Potential Technical Debt or Future Optimizations
- **Optimization**: Further componentization of common UI elements (e.g., buttons, badges) into the `components/` directory.
- **Cleanup**: Ensure all templates consistently use the new structure for any future additions.
