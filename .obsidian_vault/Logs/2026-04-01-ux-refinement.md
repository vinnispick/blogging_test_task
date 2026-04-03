# Log: 2026-04-01 - Phase 9 UX Refinement

## Technical Decisions Made (ADR Style)
- **Partial Rendering**: Extracted article grid logic into `category_articles_partial.tpl` to enable atomic DOM updates via AJAX.
- **AJAX Detection**: Updated `CategoryPageAction` to detect `ajax` query parameter or `X-Requested-With` header, serving only the partial if present.
- **DOM Parsing**: Chose to fetch the full page via AJAX and parse the DOM on the client side to update both Sort UI and Article List. This ensures consistency and "One Source of Truth" for the UI components without complex JSON APIs.
- **Sort Stack Pattern**: Implemented a "stack" approach for multi-sorting where users can toggle direction by clicking a tag or remove a layer by clicking "x". This replaces the previous limited primary/secondary system.

## Modified Files
- `src/Actions/CategoryPageAction.php`: Added AJAX detection and partial template routing.
- `templates/category_page.tpl`: Implemented Sort Stack UI, AJAX JS Engine, and transition CSS.
- `templates/category_articles_partial.tpl` [NEW]: Extracted grid/pagination for reuse.

## Potential Technical Debt or Future Optimizations
- **JS Bundling**: JS is currently inline in `category_page.tpl`. Moving to a dedicated `/static/js/category.js` would be cleaner for larger projects.
- **Routing**: AJAX detection could be moved to a Middleware or the Router level if more pages start using AJAX.
- **State Management**: Using `history.pushState` works well, but a more formal state management (even in pure JS) might be needed for complex filtering.
