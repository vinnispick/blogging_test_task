# 2026-04-01: ArticleService Implementation

## Technical Decisions (ADR Style)

1.  **Service Layer Orchestration:** Introduced `ArticleService` to decouple Actions from the raw Repositories. This layer handles pagination logic and multi-repository coordination.
2.  **Pagination DTO:** Created `PaginationResult` as a "pretty-coded" readonly entity. It bundles articles with UI-heavy metadata like `categoryName`, `totalItems`, and `totalPages`.
3.  **Boundary Safety:** The Service layer ensures that invalid page numbers are normalized and non-existent categories throw a `RuntimeException` to be caught by the Front Controller.
4.  **UI Data Enrichment:** Per user request, the `PaginationResult` now includes the `categoryName`, eliminating the need for the Action to make an additional call for the header text.

## Modified/Created Files

- `src/Domain/ArticleService.php` [NEW]
- `src/Domain/PaginationResult.php` [NEW]
- `src/Core/Container.php` [MODIFY] (Registered ArticleService)

## Potential Technical Debt & Future Optimizations

- **Exception Handling:** Currently using basic `RuntimeException`. As the app grows, specialized exceptions like `CategoryNotFoundException` should be added.
- **Sorting Whitelist:** Sorting in `ArticleRepository` is whitelisted, but the Service could also provide a more structured way to handle sorting options (e.g., an Enum).

---
*Created by Antigravity (AI Agent).*
