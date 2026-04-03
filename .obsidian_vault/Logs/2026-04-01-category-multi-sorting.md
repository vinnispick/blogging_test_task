# 2026-04-01: Multi-sorting & Ordering Choice Implementation

## Technical Decisions (ADR Style)

1.  **Multi-Sort Parser:** Implemented a parser in `CategoryPageAction` that translates comma-separated `column:dir` strings (e.g., `sort=view_count:desc,published_at:desc`) into a structured array of sort criteria. This allows for arbitrary sorting combinations while maintaining a clean URL structure.
2.  **Dynamic ORDER BY with Whitelisting:** Updated `ArticleRepository::findByCategory` to build the `ORDER BY` clause dynamically from the sort criteria array. Strictly whitelisted column names and directions to prevent SQL Injection.
3.  **Premium Sorting UI:** Replaced basic sorting links with a more interactive component in `category_page.tpl`.
    - Integrated primary sort selection with an explicit direction toggle (ASC/DESC) on the active column.
    - Added a "Secondary Sort" shortcut to demonstrate the multi-sorting capability.
4.  **Glassmorphic Design:** Applied modern CSS (backrop-filter, gradients, smooth transitions) to the sorting controls and pagination for a high-end "enterprise" feel.

## Modified/Created Files

- `src/Domain/ArticleRepository.php` [MODIFY] (Added multi-sort support)
- `src/Domain/ArticleService.php` [MODIFY] (Updated signature)
- `src/Actions/CategoryPageAction.php` [MODIFY] (Added sort string parser)
- `templates/category_page.tpl` [MODIFY] (Premium UI implementation)
- `verify_multisort.php` [NEW] (Verification script)

## Potential Technical Debt & Future Optimizations

- **URL Complexity:** As more sorting options are added, the `sort` parameter could become long. Consider a more compact encoding if needed.
- **UI Flexibility:** Currently, only two levels of sorting are explicitly prompted. For massive datasets, a more advanced "sort builder" could be implemented.
- **Smarty Logic:** Some URL-building logic is handled directly in the template. If complex URL generation becomes frequent, a dedicated URL builder service should be introduced.

---
*Created by Antigravity (AI Agent).*
