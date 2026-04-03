# Log: 2026-04-01 Category Page Refinement

## Technical Decisions (ADR)

1.  **DTO Enhancement**: Added `categoryId` to `PaginationResult`. This was necessary because the templates need the ID to build sort/pagination links, and previously they were relying on an undefined property.
2.  **Service Update**: Updated `ArticleService` to populate the new `categoryId` field.
3.  **Action Parameter Normalization**: Added whitelisting for `sort` and `order` parameters in `CategoryPageAction` to ensure the application only uses valid SQL ordering clauses.
4.  **No-Framework Constraint**: Maintained the pure PHP/Smarty approach by keeping logic within the Action and Domain layers.

## Modified Files

- `src/Domain/PaginationResult.php` [MODIFY]
- `src/Domain/ArticleService.php` [MODIFY]
- `src/Actions/CategoryPageAction.php` [MODIFY]
- `.obsidian_vault/Current_Task.md` [MODIFY]

## Potential Technical Debt / Future Optimizations

- **URL Builder**: Currently, links are hardcoded in the TPL (`?id={$pagination->categoryId}...`). A simple URL builder helper could make this more robust.
- **Order Toggle**: The current view keeps the SAME order when clicking a different sort criteria. A more intuitive UX would be to default to DESC for date/views and ASC for title.
