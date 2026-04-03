# Log: 2026-04-01 - Article Page Refinement

## Technical Decisions Made (ADR STYLE)
- **Reading Time Logic**: Implemented word-counting logic within `ArticlePageAction`. While this could be a helper, keeping it in the Action follows the ADR pattern (Action preparing data for the Responder). Baseline: 200 words per minute.
- **Component Specialization**: Created `_similar_article_mini.tpl` specifically for sidebar constrained views. Reusing the main article card was visually jarring. This follows the Principle of Least Surprise and Atomic Design.
- **Micro-Animations**: Used pure CSS animations (`@keyframes`) for fade-in and slide-up effects. This enhances UX without the overhead of JS libraries.
- **Typography & Grid**: Moved to a 75/25 split for the Article Detail view. Limited reading width to 800px to maintain line length for better readability (Standard UX practice).

## Modified Files
- `src/Actions/ArticlePageAction.php`: Added `readingTime` calculation.
- `templates/article_page.tpl`: Complete structural and style overhaul.
- `templates/components/_similar_article_mini.tpl` [NEW]: Created for sidebar layout.

## Potential Technical Debt or Future Optimizations
- **Styling**: Inline CSS in templates is growing. Moving to a separate Sass/CSS file for Article page specifics would improve cacheability and maintainability.
- **Reading Time**: Could be cached in the database if articles become very long.
- **SEO**: Meta tags (OpenGraph) could be enhanced based on the new premium layout.
