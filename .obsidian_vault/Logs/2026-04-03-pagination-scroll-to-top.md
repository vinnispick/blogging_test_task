# Log: 2026-04-03 - Pagination Scroll to Top

## Technical Decisions (ADR Style)
* **Decision:** Implement window scroll to top when pagination links are clicked in the `CategoryPage`.
* **Rationale:** Better UX when navigating between pages. Sorting actions should *not* scroll to top to preserve context, but pagination implies starting a new view.
* **Implementation:** Added a check for `.page-link` class in the AJAX click handler in `category_page.tpl`.

## Modified Files
* `templates/category_page.tpl`: Updated AJAX click handler.

## Potential Technical Debt or Future Optimizations
* Currently uses a hardcoded class check. If more components need AJAX pagination, a more generic approach like `data-scroll-to-top="true"` could be used.
